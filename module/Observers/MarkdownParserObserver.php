<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer;
use Michelf\MarkdownExtra;

class MarkdownParserObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents(array('viewParseContent'));
    }

    public function run()
    {
        $this->triggerEvent('beforeMarkdownParserObserverRun', $this->getTriggeredEventParams());

        $params = $this->getTriggeredEventParams();

        $params['page']->setContent(MarkdownExtra::defaultTransform($params['page']->getContent()));

        $this->triggerEvent('afterMarkdownParserObserverRun', $this->getTriggeredEventParams());
    }
}