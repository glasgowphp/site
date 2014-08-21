<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer,
    mizzenlite\module\Navigation\NavSort
;
/**
 * Example of navigation sorting module
 */
class NavigationSortObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents(['navigationCreatePageMenuAfter']);
    }

    public function run()
    {
        $params = $this->getTriggeredEventParams();
        $nav    = $params['navigation'];
        $menu = $nav->getMenu();

        (new NavSort())->sortByConfigNav(
            $menu,
            $this->getBag()->get('config')->nav->replace
        );
    }
}