<?php

namespace Module\Strayobject\Navigation;

use Knp\Menu\Util\MenuManipulator;
use Knp\Menu\ItemInterface;

class NavSort
{
    /**
     * @todo requires testing; works on root only;
     * @param  ItemInterface $menu
     * @param  StdClass $nav
     */
    public function sortByConfigNav(ItemInterface $menu, \StdClass $nav)
    {
        $menuManipulator = new MenuManipulator();

        foreach (array_keys((array) $nav) as $key => $page) {
            $menuManipulator->moveToPosition($menu[$page], $key);
        }
    }
}