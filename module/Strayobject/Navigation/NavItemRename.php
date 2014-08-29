<?php

namespace Module\Strayobject\Navigation;

class NavItemRename
{
    public function rename(array $params, \StdClass $replace)
    {
        $path = $params['path'];

        if (isset($replace->{$path})) {
            $params['menu'][$path]->setLabel(
                $replace->{$path}
            );
        }
    }
}