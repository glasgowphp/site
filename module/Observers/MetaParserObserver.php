<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer;
use mizzenlite\module\MetaParser\MetaParser;

class MetaParserObserver extends Observer
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