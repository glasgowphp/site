<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer;
use mizzenlite\module\OAuthSignIn\OAuthSignIn;
use mizzenlite\module\OAuthSignIn\AttendeeRepository;
use mizzenlite\module\OAuthSignIn\AttendeeStorage;
use mizzenlite\module\News\NewsList;
use mizzenlite\module\News\NewsUpcoming;
use CommonApi\Exception\RuntimeException;

class OAuthSignInObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents(array('appRun', 'beforeViewRender'));
    }
    /**
     * @todo add logging
     */
    public function run()
    {
        $upcoming = (new NewsUpcoming(new NewsList()))->findNextPost();
        $location = 'var/attendee/';
        $file     = preg_replace('/[^a-zA-Z0-9-]/', '-', $upcoming->getPath());

        if ($this->getTriggeredEvent() == 'appRun') {
            (new OAuthSignIn())->run($location.$file);
        }

        if ($this->getTriggeredEvent() == 'beforeViewRender') {
            $view = $this->getTriggeredEventParams()['view'];

            if (!$upcoming) {
                $view->attendees = [];

                return;
            }

            try {
                $attendeeRepository = (new AttendeeRepository())->jsonUnserialize(
                    (new AttendeeStorage($location.$file))->getData()
                );
                $view->attendees = $attendeeRepository->getAttendees();
            } catch (RuntimeException $e) {
                $view->attendees = [];
            } catch (\Exception $e) {
                $view->attendees = [];
            }
        }
    }
}