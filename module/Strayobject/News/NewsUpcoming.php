<?php

namespace Module\Strayobject\News;

use Module\Strayobject\News\NewsSortByDate;
use Module\Strayobject\News\NewsListInterface;

/**
 * This is experimental functionality
 */
class NewsUpcoming
{
    /**
     * @var NewsListInterface
     */
    private $newsList;

    public function __construct(NewsListInterface $newsList)
    {
        $this->setNewsList($newsList);
    }

    public function findUpcomingPosts()
    {
        $upcoming = [];
        $newsSort = new NewsSortByDate($this->getNewsList());
        $posts    = $newsSort->getNewsList()->getPosts();
        $dates    = array_keys($posts);
        $today    = new \DateTime();

        foreach ($dates as $date) {
            if (new \DateTime($date.' 23:59:59') >= $today) {
                $upcoming[$date] = $posts[$date];
            }
        }

        if (!$upcoming) {
            $post = array_pop($posts);
            $upcoming[$post->getMeta()->date] = $post;
        }

        $this->getNewsList()->setPosts($upcoming);
    }

    public function findNextPost()
    {
        $this->findUpcomingPosts();
        $posts = $this->getNewsList()->getPosts();

        return reset($posts);
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