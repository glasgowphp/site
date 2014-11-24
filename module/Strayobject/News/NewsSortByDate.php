<?php

namespace Module\Strayobject\News;

use CommonApi\Exception\InvalidArgumentException;
use Mizzencms\Core\Page\PageInterface;

/**
 * This is experimental functionality
 */
class NewsSortByDate
{
    /**
     * @var NewsListInterface
     */
    private $newsList;
    /**
     * @var bool
     */
    private $dirAsc;

    public function __construct(NewsListInterface $newsList, $dirAsc = true)
    {
        $this->setNewsList($newsList);
        $this->setDirAsc($dirAsc);
        $this->sortByDate();
    }

    public function sortByDate()
    {
        $sorted = [];
        
        foreach ($this->getNewsList()->getPosts() as $post) {
            if ($post instanceof PageInterface === false) {
                throw new InvalidArgumentException(
                    'All posts have to be instances of PageInterface.'
                );
            }

            /**
             * skip directories
             */
            if (!$post->getMeta()->date) continue;

            $sorted[$post->getMeta()->date] = $post;
        }

        if ($this->getDirAsc()) {
            ksort($sorted);
        } else {
            krsort($sorted);
        }

        $this->getNewsList()->setPosts($sorted);
    }

    /**
     * Gets the value of dirAsc.
     *
     * @return bool
     */
    public function getDirAsc()
    {
        return $this->dirAsc;
    }
    
    /**
     * Sets the value of dirAsc.
     *
     * @param bool $dirAsc the dir asc 
     *
     * @return self
     */
    public function setDirAsc($dirAsc)
    {
        $this->dirAsc = $dirAsc;

        return $this;
    }

    /**
     * Gets the value of newsList.
     *
     * @return NewsListInterface
     */
    public function getNewsList()
    {
        return $this->newsList;
    }
    
    /**
     * Sets the value of newsList.
     *
     * @param NewsListInterface $newsList the news list 
     *
     * @return self
     */
    public function setNewsList(NewsListInterface $newsList)
    {
        $this->newsList = $newsList;

        return $this;
    }
}