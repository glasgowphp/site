<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer;
use mizzenlite\module\FormGenerator\FormGenerator;

class FormGeneratorObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents(array('afterViewParseContent'));
    }

    public function run()
    {
        $this->triggerEvent('beforeMarkdownParserObserverRun', $this->getTriggeredEventParams());
        $params        = $this->getTriggeredEventParams();
        $formGenerator = new FormGenerator();
        $formGenerator->setCurrentPage($params['page']->getPath());

        if ($formGenerator->hasFormForPage()) {
            $params['page']->setContent($formGenerator->generate($params['page']->getContent()));
        }

        $this->triggerEvent('afterMarkdownParserObserverRun', $this->getTriggeredEventParams());
    }
}