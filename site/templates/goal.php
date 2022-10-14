<?php snippet('header') ?>
        <?= css('assets/css/templates/goal.css') ?>
    <?php
        $goal = $page->goal()->toInt();
        $numb = $page->current()->toInt();
        $percent = $numb / $goal * 100;
    ?>
    </head>
    <body>
        <h1><?= $page->headline() ?></h1>
        <div class="progress-wrapper">
            <div class="progress-bar progress-round" style="width:<?=$percent ?>%"></div>
        </div>
        <div class="text-main">
            <h2>Goal - <?= $page->current() ?> / <?= $page->goal() ?></h2>
            <p><?= kirbytext($page->textbody()) ?></p>
        </div>
    </body>
</html>
