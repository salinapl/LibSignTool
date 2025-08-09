<ul class="evlist">
    <?php foreach($arrayReady as $jsonData): ?>
        <?php
            $startDate = strtotime($jsonData['start_date']);
            $startTime = date("g:ia", $startDate);
            $endDate = strtotime($jsonData['end_date']);
            $endTime = date("g:ia", $endDate);
        ?>
        <li>
            <h2><?= $jsonData['title'] . "|" . $jsonData['branch'][0] ?></h2>
            <span class="time">
                <?= $startTime . '-' . $endTime?>
            </span>
            <span>
                <?= date("l, F jS", $startDate) ?>
        </li>
    <?php endforeach ?>
</ul>
