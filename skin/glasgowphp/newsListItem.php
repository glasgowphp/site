<?php
    $speakers = json_decode($this->meta->speaker);

    if (!$speakers) {
        $speakers = [];
    }
?>
<div class="item-row">
    <div class="box-meta">
        <p>Meetup date: <?= $this->meta->date; ?></p>
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