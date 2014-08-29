<?php

namespace Module\Strayobject\Navigation;

use Strayobject\Mizzenlite\Observer;
use Module\Strayobject\Navigation\NavSort;
use Module\Strayobject\Navigation\NavItemHide;

/**
 * Example of navigation sorting module
 */
class Module extends Observer
{
    public function __construct()
    {
        $this->setEvents([
            'navigationCreatePageMenuAfter',
            'navigationAddToParentAfter',
            'navigationAddToMenuAfter'
        ]);
    }

    public function run()
    {
        $params = $this->getTriggeredEventParams();

        switch ($this->getTriggeredEvent()) {
            case 'navigationCreatePageMenuAfter':
                /**
                 * Hide items
                 */
                $NavItemHide = new NavItemHide(
                    $params, 
                    $this->getBag()->get('config')->nav->exclude
                );

                $NavItemHide->hideInRoot();
                /**
                 * Sort Items
                 */
                (new NavSort())->sortByConfigNav(
                    $params['navigation']->getMenu(),
                    $this->getBag()->get('config')->nav->replace
                );
                break;
            case 'navigationAddToParentAfter':
                $NavItemHide = new NavItemHide(
                    $params, 
                    $this->getBag()->get('config')->nav->exclude
                );

                $NavItemHide->hideInChild();
                break;
            case 'navigationAddToMenuAfter':
                (new NavItemRename())->rename(
                    $params,
                    $this->getBag()->get('config')->nav->replace
                );
                break;
        }
    }
}