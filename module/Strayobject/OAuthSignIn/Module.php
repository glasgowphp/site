<?php

namespace Module\Strayobject\OAuthSignIn;

use Strayobject\Mizzenlite\Observer;
use Module\Strayobject\OAuthSignIn\OAuthSignIn;
use Module\Strayobject\OAuthSignIn\AttendeeRepository;
use Module\Strayobject\OAuthSignIn\AttendeeStorage;
use Module\Strayobject\News\NewsList;
use Module\Strayobject\News\NewsUpcoming;
use CommonApi\Exception\RuntimeException;

class Module extends Observer
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