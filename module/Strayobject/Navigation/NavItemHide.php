<?php

namespace Module\Strayobject\Navigation;

class NavItemHide
{
    private $params;
    private $exclude;

    public function __construct(array $params, \StdClass $exclude)
    {
        $this->setParams($params);
        $this->setExclude($exclude);
    }

    public function hideInRoot()
    {
        $nav = $this->getParams()['navigation'];

        foreach ($this->getExclude() as $exPath) {
            if (!strpos($exPath, '/') && isset($nav->getMenu()[$exPath])) {
                $nav->getMenu()[$exPath]->setDisplay(false);
            }
        }
    }

    public function hideInChild()
    {
        $menu    = $this->getParams()['menu'];
        $parents = $this->getParams()['parents'];
        $child   = $this->getParams()['child'];

        foreach ($this->getExclude() as $exPath) {
            if (strpos($exPath, '/')) {
                $exParents = explode('/', $exPath);
                $exChild   = array_pop($exParents);

                if (!array_diff($parents, $exParents) && $child === $exChild) {
                    $menu[$child]->setDisplay(false);
                }
            }
        }
    }

    /**
     * Gets the value of params.
     *
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Sets the value of params.
     *
     * @param array $params the params
     *
     * @return self
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Gets the value of exclude.
     *
     * @return mixed
     */
    public function getExclude()
    {
        return $this->exclude;
    }

    /**
     * Sets the value of exclude.
     *
     * @param StdClass $exclude the exclude
     *
     * @return self
     */
    public function setExclude(\StdClass $exclude)
    {
        $this->exclude = $exclude;

        return $this;
    }
}