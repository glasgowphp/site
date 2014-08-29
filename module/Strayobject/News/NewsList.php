<?php

namespace Module\Strayobject\News;

use Strayobject\Mizzenlite\Base;
use Module\Strayobject\News\NewsListInterface;
/**
 * This is experimental functionality
 */
class NewsList extends Base implements NewsListInterface
{
    /**
     * @var array
     */
    private $posts = [];

    public function __construct()
    {
        parent::__construct();

        $this->makeList();
    }
    /**
     * 
     */
    protected function makeList()
    {
        $pr  = $this->getBag()->getShared('pageRepository');
        $dir = $this->getBag()->getShared('config')->module->news->dir;

        $this->setPosts($pr->findAllInDirPath($dir.'/'));
    }

    /**
     * Gets the value of posts.
     *
     * @return array
     */
    public function getPosts()
    {
        return $this->posts;
    }
    
    /**
     * Sets the value of posts.
     *
     * @param array $posts the posts 
     *
     * @return self
     */
    public function setPosts(array $posts)
    {
        $this->posts = $posts;

        return $this;
    }
}