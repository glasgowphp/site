<?php

namespace mizzenlite\module\News;

use mizzenlite\module\News\NewsSortByDate;
use mizzenlite\module\News\NewsListInterface;

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
            if (new \DateTime($date) >= $today) {
                $upcoming[$date] = $posts[$date];
            }
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