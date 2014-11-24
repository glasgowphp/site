<?php

namespace Module\Strayobject\OAuthSignIn;

use Mizzencms\Core\Base;
use Module\Strayobject\OAuthSignIn\Attendee;

class AttendeeRepository extends Base implements \JsonSerializable
{
    private $attendees = [];

    public function add(Attendee $attendee)
    {
        $this->setAttendees(
            [$attendee->getScreenName() => $attendee] + $this->getAttendees()
        );
    }

    public function remove($screenName)
    {
        $attendees = $this->getAttendees();
        unset($attendees[$screenName]);

        $this->setAttendees($attendees);
    }

    public function has($screenName)
    {
        return array_key_exists($screenName, $this->getAttendees());
    }

    public function findByScreenName($screenName)
    {
        if ($this->has($screenName)) {
            return $this->getAttendees()[$screenName];
        }

        return false;
    }

    public function jsonSerialize()
    {
        $attendees = [];

        foreach ($this->getAttendees() as $attendee) {
            $attendees[$attendee->getScreenName()] = [
                'name'       => $attendee->getName(),
                'screenName' => $attendee->getScreenName(),
                'imageLink'  => $attendee->getImageLink()
            ];
        }

        return $attendees;
    }
    /**
     * @param  string $data json
     * @return self
     */
    public function jsonUnserialize($data)
    {
        if ($data && $decoded = json_decode($data, true)) {
            foreach ($decoded as $row) {
                if ($row) {
                    $attendee = new Attendee();

                    foreach ($row as $key => $value) {
                        if (method_exists($attendee, 'set'.ucfirst($key))) {
                            $attendee->{'set'.ucfirst($key)}($value);
                        }
                    }

                    $this->add($attendee);
                }
            }
        }

        return $this;
    }

    /**
     * Gets the value of attendees.
     *
     * @return mixed
     */
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * Sets the value of attendees.
     *
     * @param mixed $attendees the attendees
     *
     * @return self
     */
    public function setAttendees($attendees)
    {
        $this->attendees = $attendees;

        return $this;
    }
}