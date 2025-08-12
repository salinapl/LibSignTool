<ul class="evlist">
    <?php foreach($arrayReady as $jsonData): ?>
        <?php
            $rawStartDt = $jsonData['start_date'];
            $startDate  = new DateTime($rawStartDt);
            $rawEndDt   = $jsonData['end_date'];
            $endDate    = new DateTime($rawEndDt);
            $title      = $jsonData['title'];
            $branch     = trim($jsonData['branch']);
            $room       = trim($jsonData['room']);
            $dateString = '';
            $timeString = '';

            // Check if event lasts longer than a day
            // Set date and time string if only 1 day event
            // else set a start and end date and no time string
            if ($startDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
                $dateString = $startDate->format('l, F jS') . ' ';

                $timeString = $startDate->format('g:ia')
                            . ' - '
                            . $endDate->format('g:ia');
            } else {
                $dateString = $startDate->format('l, F jS')
                            . ' - '
                            . $endDate->format('l, F jS');
            }

            // Check if branch and room are unique, collapse if not
            $location = array_filter(
                array_unique([$branch, $room]),
                fn($v) => $v !== ''
            );
            
            // build location string
            $string = '';
            if(!empty($location)) {
                $string = ' | ' . implode(' - ', $location);
            }
        ?>
        <li>
            <h2><?= htmlspecialchars($title . $string) ?></h2>
            <span class="time">
                <?= htmlspecialchars($timeString) ?>
            </span>
            <span>
                <?= htmlspecialchars($dateString) ?>
            </span>
        </li>
    <?php endforeach ?>
</ul>
