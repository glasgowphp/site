<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer,
    mizzenlite\module\NavSort\NavSort
;
/**
 * Example of navigation sorting module
 */
class NavigationItemNameReplaceObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents(['navigationAddToMenuAfter']);
    }

    public function run()
    {
        $params  = $this->getTriggeredEventParams();
        $path    = $params['path'];
        $replace = $this->getBag()->get('config')->nav->replace;

        if (isset($replace->{$path})) {
            $params['menu'][$path]->setLabel($replace->{$path});
        }
    }
}