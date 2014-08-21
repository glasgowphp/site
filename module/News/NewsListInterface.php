<?php

namespace mizzenlite\module\News;

interface NewsListInterface
{
    public function getPosts();
    public function setPosts(array $posts);
}