<?php snippet('lst-header') ?>
        <?= css('/media/plugins/salinapl/libsigntool/fonts/remixicon.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/error-slide.css') ?>
    </head>
    <body>
        <div class="flex-box">
            <div class="flex-item">
                <h1><i class="<?= $page->icon() ?>"></i><?= $page->headline() ?></h1>
                <?= $page->body()->kirbytext() ?>
            </div>
        </div>
        <?php snippet('lst-footer') ?>