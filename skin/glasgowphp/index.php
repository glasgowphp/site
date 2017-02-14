<?php
    if (isset($this->meta->speaker)) {
        $speakers = json_decode($this->meta->speaker);
    } else {
        $speakers = [];
    }

    if (isset($this->meta->attlink)) {
        $attlink = json_decode($this->meta->attlink);
    } else {
        $attlink = new stdClass();
    }

    if (isset($this->meta->venue)) {
        $venue = json_decode($this->meta->venue);
    } else {
        $venue = new stdClass();
        $venue->address = 'Markup, 10 Newton Terrace, Glasgow';
        $venue->longitude = -4.2749712461898;
        $venue->latitude =  55.865997252861;
    }
?>
<div class="container-box">
    <!--<h1><?= $this->meta->title; ?></h1>-->
    <h1>Upcoming Meetup</h1>
<?php if (isset($this->meta->subtitle)) { ?>
    <h2><?= $this->meta->subtitle; ?></h2>
<?php } ?>
    <div class="content-box">
        <div class="box-meta">
            <p>Meetup on: <?= (new \DateTime($this->meta->date))->format('l, jS \of F'); ?></p>
            <p>Time: <?= $this->meta->time; ?></p>
            <p>Location: <a href="#location">Our venue</a></p>
            <p>Speaker:</p>
            <ul class="speaker-list">
<?php
            foreach ($speakers as $speaker) {
                echo '<li>';
                    echo '<img src="'.$speaker->image.'"/>';
                    echo '<a href="'.$speaker->link.'">'.$speaker->name.'</a>';
                echo '</li>';
            }
?>
            </ul>
        </div>
        <?= $this->content; ?>
        <hr/>
        <strong>
            Get updates by following
            <a href="https://twitter.com/glasgowphp">glasgowphp</a>
            or <a href="irc://irc.freenode.net/glasgowphp">join our IRC channel</a>
            <sup>(<a href="http://webchat.freenode.net/?channels=#glasgowphp">webchat</a>)</sup>
            or <a href="https://slack.scotlandphp.co.uk">join us on ScotlandPHP Slack</a>
        </strong>
    </div>
</div>
<div class="container-box">
    <h1>Attendees</h1>
    <h2>Will you join us?</h2>
    <div class="box-attendees">
        <ul>
<?php
foreach ($this->attendees as $attendee) {
    echo '<li>';
        echo '<a href="https://twitter.com/'.$attendee->getScreenName().'" title="'.$attendee->getName().'">';
            echo '<img src="'.$attendee->getImageLink().'" alt="'.$attendee->getName().'"/>';
        echo '</a>';
    echo'</li>';
}

if (!$this->attendees) {
    echo '<li class="empty">The usual bunch.</li>';
}
?>
        </ul>
        <div class="info">
            <a href="?oauth=go"><button>Confirm via Twitter</button></a>
<?php
        if (isset($attlink->otc)) {
?>
            <br/><br/>
            <a href="<?= $attlink->otc; ?>">
                <button>Confirm on <br/>Open Tech Calendar</button>
            </a>
<?php
        }
        if (isset($attlink->eb)) {
?>
            <br/><br/>
            <a href="<?= $attlink->eb; ?>">
                <button>Confirm on Eventbrite</button>
            </a>
<?php
        }
        if (isset($attlink->mu)) {
?>
            <br/><br/>
            <a href="<?= $attlink->mu; ?>">
                <button>Confirm on Meetup</button>
            </a>
<?php
        }
?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="container-box">
    <a name="location"></a>
    <h1>Location</h1>
    <h2>Find our venue:</h2>
    <div class="box-location">
        <p><?= $venue->address; ?></p>
        <script>
            var venue_lon = <?= $venue->longitude; ?>;
            var venue_lat = <?= $venue->latitude; ?>;
        </script>
        <div id="map" class="map"></div>
    </div>
</div>
