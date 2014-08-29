<?php

namespace Module\Strayobject\News;

use Strayobject\Mizzenlite\Observer;
use Module\Strayobject\News\NewsList;
use Module\Strayobject\News\NewsSortByDate;

class Module extends Observer
{
    private $flagRun;

    public function __construct()
    {
        $this->setEvents(array('afterViewParseContent'));
    }

    public function run()
    {
        $params = $this->getTriggeredEventParams();

        if ($this->getBag()->get('config')->module->news->page != $params['page']->getPath()) {
           return;
        }

        $this->triggerEvent('beforeNewsObserverRun', $this->getTriggeredEventParams());

        if ($this->flagRun !== 1) {
            $this->flagRun = 1;
        } else {
            return;
        }

        $content = '';
        $list    = (new NewsSortByDate(new NewsList(), false))->getNewsList();


        if ($list->getPosts()) {
            foreach ($list->getPosts() as $page) {
                if ($page->isDir()) continue;

                $view = $this->getBag()->get('view');
                $content .= $view->partial($page->getPath(), 'newsListItem.php', false);
            }
        }

        if ($content) {
            $pageMeta = $params['page']->getMeta();
            $pageMeta->hideMetaBox = 1;
            $params['page']->setMeta($pageMeta);
            $params['page']->setContent($content);
        }

        $this->triggerEvent('afterNewsObserverRun', $this->getTriggeredEventParams());
    }
}