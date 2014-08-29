<?php

use Module\Strayobject\News\NewsUpcoming;
use Module\Strayobject\News\NewsList;

$basePath = dir(realpath(__DIR__));

require $basePath->path.'/vendor/autoload.php';

$app = new Strayobject\Mizzenlite\App();
$app->init($basePath);
$app->getBag()->add('newsList', function () {
    return new NewsList();
});
$app->getBag()->add('newsUpcoming', function () {
    return new NewsUpcoming(new NewsList());
});

echo $app->run();