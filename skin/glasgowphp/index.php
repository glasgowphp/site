<?php
    if (isset($this->meta->speaker)) {
        $speakers = json_decode($this->meta->speaker);
    } else {
        $speakers = [];
    }

    if (isset($this->meta->attlink)) {
        $attlink = json_decode($this->meta->attlink);
    } else {
        $attlink = stdClass;
    }
?>
<div class="container-box">
    <h1><?= $this->meta->title; ?></h1>
<?php if (isset($this->meta->subtitle)) { ?>
    <h2><?= $this->meta->subtitle; ?></h2>
<?php } ?>
    <div class="content-box">
        <div class="box-meta">
            <p>Meetup on: <?= $this->meta->date; ?></p>
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
        <p>Top floor of Sir Alwyn Williams Building, 18 Lilybank Gardens, Glasgow, G12 8QQ, Scotland</p>
        <div id="map" class="map"></div>
    </div>
</div>