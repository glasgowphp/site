<?php

namespace Module\Strayobject\OAuthSignIn;

use Mizzencms\Core\Base;

class Attendee extends Base implements \JsonSerializable
{
    private $name;
    private $screenName;
    private $imageLink;

    public function parseTwitterResponse($response)
    {
        $this->setName($response->name);
        $this->setScreenName($response->screen_name);
        $this->setImageLink($response->profile_image_url);

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'name'       => $this->getName(),
            'screenName' => $this->getScreenName(),
            'imageLink'  => $this->getImageLink()
        ];
    }
    /**
     * @todo  untested
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function jsonUnserialize($data)
    {
        $attendee = new self();

        foreach (json_decode($data, true) as $key => $value) {
            if (method_exists($attendee, 'set'.ucfirst($key))) {
                $attendee->{'set'.ucfirst($key)}($value);
            }
        }

        return $attendee;
    }
    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of screenName.
     *
     * @return mixed
     */
    public function getScreenName()
    {
        return $this->screenName;
    }

    /**
     * Sets the value of screenName.
     *
     * @param mixed $screenName the screen name
     *
     * @return self
     */
    public function setScreenName($screenName)
    {
        $this->screenName = $screenName;

        return $this;
    }

    /**
     * Gets the value of imageLink.
     *
     * @return mixed
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * Sets the value of imageLink.
     *
     * @param mixed $imageLink the image link
     *
     * @return self
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;

        return $this;
    }
}