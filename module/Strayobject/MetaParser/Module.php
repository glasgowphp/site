<?php

namespace Module\Strayobject\MetaParser;

use Strayobject\Mizzenlite\Observer;
use Module\Strayobject\MetaParser\MetaParser;

class Module extends Observer
{
    public function __construct()
    {
        $this->setEvents([]);//array('beforeParseContent'));
    }

    public function run()
    {
        if ($this->getTriggeredEvent() == 'beforeParseContent') {

            $this->triggerEvent('beforeMetaParserObserverRun', $this->getTriggeredEventParams());

            $params = $this->getTriggeredEventParams();

            (new MetaParser())->parse($params['page']->getContent());

            $this->triggerEvent('afterMetaParserObserverRun', $this->getTriggeredEventParams());
        }
    }
}