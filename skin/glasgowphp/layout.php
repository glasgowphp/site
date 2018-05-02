<!DOCTYPE html>
<html lang="en" class="">
<head>
    <title><?= $this->config->siteName; ?>: <?= $this->meta->title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $this->meta->description; ?>"/>
    <link rel="stylesheet" type="text/css" href="/skin/shared/css/normalize.css"/>
    <link rel="stylesheet" type="text/css" href="/skin/shared/font/lato/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="/skin/shared/font/bowlby-one/stylesheet.css"/>
    <link rel="stylesheet" type="text/css" href="/skin/shared/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/skin/glasgowphp/css/main.css" rel="stylesheet"/>
    <script src="/skin/shared/js/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.13.1/OpenLayers.js"></script>
    <script src="/skin/glasgowphp/js/script.js"></script>
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/skin/glasgowphp/images/g-shield-2-small.png" alt="Glasgow PHP logo" class="logo"/>
                    <h1><?= $this->config->siteName; ?></h1>
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <?= $this->navigation->render(); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="main-wrapper">
        <div class="container main">
            <div class="content-left">
<?php
            if ($this->getPage()->getPath() === 'index') {
                $page = $this->newsUpcoming->findNextPost();

                if (!$page) {
                    $page = $this->getPage();
                }

                echo $this->partial($page->getPath(), 'index.php', false);
            } else {
                echo '<div class="container-box">';
                    echo '<h1>'.$this->meta->title.'</h1>';

                if (isset($this->meta->subtitle)) {
                    echo '<h2>'.$this->meta->subtitle.'</h2>';
                }
                    echo '<div class="content-box">';

                    if (!isset($this->meta->hideMetaBox) || !$this->meta->hideMetaBox) {
?>
                        <div class="box-meta">
                            <p>Meetup date: <?= (new \DateTime($this->meta->date))->format('l, jS \of F'); ?></p>
                            <p>Speaker:</p>
                            <ul class="speaker-list">
<?php
                            $speakers = json_decode($this->meta->speaker);

                            if (!$speakers) {
                                $speakers = [];
                            }

                            foreach ($speakers as $speaker) {
                                echo '<li>';
                                    echo '<img src="'.$speaker->image.'"/>';
                                    echo '<a href="'.$speaker->link.'">'.$speaker->name.'</a>';
                                echo '</li>';
                            }
?>
                            </ul>
                        </div>
<?php
                    }
                        echo $this->content;
                    echo '</div>';
                echo '</div>';
            }
?>
            </div>
            <div class="content-right">
                <div class="container-box">
                    <h1 class="side-box">Event sponsors</h1>
                    <p>Let us know how you could <a href="/becomeasponsor">help the community</a>.</p>
<?php
                    $sponsors = [
                        'sponsors/markup',
                        'sponsors/stv',
                        'sponsors/digirati',
                        'sponsors/plainmotif',
                        'sponsors/inviqa',
                        'sponsors/spaces',
                    ];
                    shuffle($sponsors);

                    foreach ($sponsors as $sponsor) {
                        echo '<div class="box-sponsor"';
                        echo $this->renderContent($sponsor);
                        echo '</div>';
                    }
?>
                    <h1 class="side-box">Raffle sponsors</h1>
                    <div class="box-sponsor">
                        <?= $this->renderContent('sponsors/jetbrains'); ?>
                    </div>
                    <!--<div class="box-sponsor">
                        <?= $this->renderContent('sponsors/saltstack'); ?>
                    </div>
                    <div class="box-sponsor">
                        <?= $this->renderContent('sponsors/digitalocean'); ?>
                    </div>
                    <div class="box-sponsor">
                        <?= $this->renderContent('sponsors/vultr'); ?>
                    </div>
                    <div class="box-sponsor">
                        <?= $this->renderContent('sponsors/zend'); ?>
                    </div>-->
                </div>
                <div class="container-box">
                    <h1 class="side-box">Latest on Twitter</h1>
                    <div class="box-sponsor twitter-widget">
                        <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/glasgowphp"  data-widget-id="478950841227816960" data-link-color="#007C85" data-chrome="nofooter noborders" data-tweet-limit="3">Tweets by @glasgowphp</a>
                        <script>
                            !function(d,s,id){
                                var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
                                if(!d.getElementById(id)){
                                    js=d.createElement(s);
                                    js.id=id;js.src=p+"://platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js,fjs);
                                }
                            }(document,"script","twitter-wjs");
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div id="footer" class="footer">
        <div class="container">
            <p>&copy; GlasgowPHP <?= date('Y'); ?></p>
        </div>
    </div>
    <script src="/skin/shared/lib/bootstrap/js/bootstrap.min.js"></script>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(["setCookieDomain", "*.glasgowphp.co.uk"]);
  _paq.push(["setDomains", ["*.glasgowphp.co.uk"]]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.plainmotif.co.uk/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '3']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.plainmotif.co.uk/piwik.php?idsite=3&rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
</body>
</html>
