<?php

namespace mizzenlite\module\NavSort;

class NavSort
{
    /**
     * @todo requires testing; what happens in dirs?
     * @param  array $data
     * @param  StdClass $nav
     * @return array
     */
    public function sortByConfigNav($data, $nav)
    {
        $sorted = [];

        foreach (array_keys((array) $nav) as $page) {
            foreach ($data as $k => $v) {
                if (isset($v['path']) && $v['path'] === '/'.$page) {
                    $sorted[] = $v;
                    unset($data[$k]);
                }
            }
        }

        if ($data) $sorted = array_merge($sorted, $data);

        return $sorted;
    }
}