<?php

use mizzenlite\module\News\NewsUpcoming;
use mizzenlite\module\News\NewsList;

$basePath = dir(realpath(__DIR__));

require $basePath->path.'/vendor/autoload.php';

$app = new Strayobject\Mizzenlite\App();
$app->init($basePath);
/**
 * @todo  remove as temporary
 */
use mizzenlite\module\MetaParser\MetaParser;
$app->getBag()->add('metaParser', function () {
    return new MetaParser();
});
/**
 **************************
 */

$app->getBag()->add('newsList', function () {
    return new NewsList();
});

$app->getBag()->add('newsUpcoming', function () {
    return new NewsUpcoming(new NewsList());
});

echo $app->run();