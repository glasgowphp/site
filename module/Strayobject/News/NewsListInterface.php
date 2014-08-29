<?php

namespace Module\Strayobject\News;

interface NewsListInterface
{
    public function getPosts();
    public function setPosts(array $posts);
}