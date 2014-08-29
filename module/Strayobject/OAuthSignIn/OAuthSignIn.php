<?php

namespace Module\Strayobject\OAuthSignIn;

use OAuth\OAuth1\Service\Twitter;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\ServiceFactory;
use Strayobject\Mizzenlite\Base;
use Module\Strayobject\OAuthSignIn\Attendee;

class OAuthSignIn extends Base
{
    /**
     * @todo  refactor!
     */
    public function run($fileLocation)
    {
        $uriFactory = new UriFactory();
        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
        $currentUri->setQuery('');

        $servicesCredentials = $this->getBag()->get('config')->module->oAuthSignIn;

        /** @var $serviceFactory \OAuth\ServiceFactory An OAuth service factory. */
        $serviceFactory = new ServiceFactory();

        // We need to use a persistent storage to save the token, because oauth1 requires the token secret received before'
        // the redirect (request token request) in the access token request.
        $storage = new Session();

        // Setup the credentials for the requests
        $credentials = new Credentials(
            $servicesCredentials->twitter->key,
            $servicesCredentials->twitter->secret,
            $currentUri->getAbsoluteUri()
        );

        // Instantiate the twitter service using the credentials, http client and storage mechanism for the token
        /** @var $twitterService Twitter */
        $twitterService = $serviceFactory->createService('twitter', $credentials, $storage);

        if (!empty($_GET['oauth_token'])) {
            $token = $storage->retrieveAccessToken('Twitter');

            // This was a callback request from twitter, get the token
            $twitterService->requestAccessToken(
                $_GET['oauth_token'],
                $_GET['oauth_verifier'],
                $token->getRequestTokenSecret()
            );

            // Send a request now that we have access token
            $result = json_decode($twitterService->request('account/verify_credentials.json'));

            /**
             * @todo  replace this with proper code && add attendee verification to eliminate duplicates
             */
            $file = $fileLocation;
            $data = [];

            if (is_readable($file)) {
                if ($old = json_decode(file_get_contents($file), true)) {
                    $data = $old;
                }
            }

            if ($this->verifyAttendeeUnique($data, $result)) {
                if ($f = fopen($file, 'w')) {
                    array_push($data, (new Attendee())->parseTwitterResponse($result)->jsonSerialize());
                    fwrite($f, json_encode($data));
                    fclose($f);
                }
            }
            header('Location: /');
        } elseif (!empty($_GET['oauth']) && $_GET['oauth'] === 'go') {
            // extra request needed for oauth1 to request a request token :-)
            $token = $twitterService->requestRequestToken();
            $url   = $twitterService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
            header('Location: '.$url);
        }
    }

    protected function verifyAttendeeUnique($existingData, $twitterResponse)
    {
        if (!is_array($existingData)) return true;

        foreach ($existingData as $attendee) {
            if ($attendee['screenName'] === $twitterResponse->screen_name) {
                return false;
            }
        }

        return true;
    }
}