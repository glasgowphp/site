<?php
    if (isset($this->meta->speaker)) {
        $speakers = json_decode($this->meta->speaker);
    } else {
        $speakers = [];
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
        echo '<img src="'.$attendee->getImageLink().'" alt="'.$attendee->getName().'"/>';
        echo '<a href="https://twitter.com/'.$attendee->getScreenName().'">';
            echo $attendee->getName();
        echo '</a>';
    echo'</li>';
}

if (!$this->attendees) {
    echo '<li>The usual bunch.</li>';
}
?>
        </ul>
        <div class="info">
            <a href="?oauth=go"><button>Confirm via Twitter</button></a>
            <br/><br/>
            <a href="https://opentechcalendar.co.uk/event/1624-monthly-glasgowphp-meetup">
                <button>Confirm on <br/>Open Tech Calendar</button>
            </a>
            <br/><br/>
            <a href="http://www.eventbrite.co.uk/e/glasgowphp-monthly-tickets-12304453953">
                <button>Confirm on Eventbrite</button>
            </a>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="container-box">
    <a name="location"></a>
    <h1>Location</h1>
    <h2>Find our venue:</h2>
    <div class="box-location">
        <p>Top floor of Sir Alwyn Williams Building, Lilybank Gardens, Glasgow, G12 8QQ, Scotland</p>
        <div id="map" class="map"></div>
    </div>
</div>