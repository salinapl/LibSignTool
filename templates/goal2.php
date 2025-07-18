<?php snippet('header') ?>
        <?= css('assets/css/templates/goal2.css') ?>
    <?php
        $goal = $page->goal()->toInt();
        $numb = $page->current()->toInt();
        $percent = $numb / $goal * 100;
        $progress = match (true) {
            $percent >= 100 => "sg100",
            $percent >= 75 => "sg75",
            $percent >= 50 => "sg50",
            $percent >= 25 => "sg25",
            default => "sg0"
        };
    ?>
    </head>
    <body>
        <div class="sbgwrapper">
            <div class="snowcontainer">
                <div class="snow snow1"></div>
                <div class="snow snow2"></div>
                <div class="snow snow3"></div>
                <div class="snow snow4"></div>
                <div class="snow snow5"></div>
                <div class="snow snow6"></div>
            </div>
            <div class="snowglobe <?= $progress ?>">
                <?php if($page->dollar()->bool()): ?>
                    <h2 class="total">$<?= $page->current() ?><br />Gifts</h2>
                    <h2 class="goal">Goal: $<?= $page->goal() ?></h2>
                <?php else: ?>
                    <h2 class="total"><?= $page->current() ?><br />Gifts</h2>
                    <h2 class="goal">Goal: <?= $page->goal() ?></h2>
                <?php endif ?>
            </div>
        </div>
        <div class="text-main">
            <h1><?= $page->headline() ?></h1>
            <p><?= kirbytext($page->textbody()) ?></p>
        </div>
    </body>
</html>