<?php

namespace mizzenlite\module\Observers;

use Strayobject\Mizzenlite\Observer,
    mizzenlite\module\Navigation\NavSort
;

class NavigationItemHideObserver extends Observer
{
    public function __construct()
    {
        $this->setEvents([
            'navigationAddToParentAfter',
            'navigationCreatePageMenuAfter',
        ]);
    }

    public function run()
    {
        $params  = $this->getTriggeredEventParams();
        $exclude = $this->getBag()->get('config')->nav->exclude;

        if ($this->getTriggeredEvent() === 'navigationAddToParentAfter') {
            $menu    = &$params['menu'];
            $parents = $params['parents'];
            $child   = $params['child'];

            foreach ($exclude as $exPath) {
                if (strpos($exPath, '/')) {
                    $exParents = explode('/', $exPath);
                    $exChild   = array_pop($exParents);

                    if (!array_diff($parents, $exParents) && $child === $exChild) {
                        $menu[$child]->setDisplay(false);
                    }
                }
            }

        } elseif ($this->getTriggeredEvent() === 'navigationCreatePageMenuAfter') {
            $nav = $params['navigation'];

            foreach ($exclude as $exPath) {
                if (!strpos($exPath, '/') && isset($nav->getMenu()[$exPath])) {
                    $nav->getMenu()[$exPath]->setDisplay(false);
                }
            }
        }
    }
}