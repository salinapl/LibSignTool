<?php snippet('header') ?>
        <?= css('assets/fonts/remixicon.css') ?>
        <?= css('assets/css/templates/error-slide.css') ?>
    </head>
    <body>
        <div class="flex-box">
            <div class="flex-item">
                <h1><i class="<?= $page->icon() ?>"></i><?= $page->headline() ?></h1>
                <?= $page->body()->kirbytext() ?>
            </div>
        </div>
        <?php snippet('footer') ?>