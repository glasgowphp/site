<?php

namespace Module\Strayobject\MarkdownParser;

use Mizzencms\Core\Observer;
use Michelf\MarkdownExtra;

class Module extends Observer
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