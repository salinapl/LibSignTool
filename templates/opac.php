<?php snippet('header') ?>
        <?= css('assets/fonts/remixicon.css') ?>
        <?= css('assets/css/flickity.min.css') ?>
        <?= css('assets/css/templates/opac.css') ?>
        <?php //snippet('analytics') ?>
    </head>
    <body>
        <div class="flex-box">
            <div class="flex-item">
                <div class="flex-full-width">

                    <div class="logo">
                        <?php if($headerImage = $page->header_image()->toFile()): ?>
                            <img src="<?= $headerImage->url() ?>">
                        <?php endif ?>
                    </div>
                    <h1><?= $page->headline() ?></h1>
                </div>
                <nav class="nav-wrapper">
                    <?php foreach($page->links()->toStructure() as $links): ?>
                    <a class="button flex-button" href="<?= $links->link() ?>"><i class="<?= $links->icon() ?>"></i><?= $links->description() ?></a>
                    <?php endforeach ?>
                </nav>
            </div>
            <?php if($page->sidebar()->bool()): ?>
                <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "autoPlay": <?= $page->delay() ?>, "pauseAutoPlayOnHover": false, "wrapAround": true, "imagesLoaded": true, "pageDots": false, "prevNextButtons": false}'>
                    <?php snippet('builder', ['orientation' => 'portrait']) ?>
                </div>
            <?php endif ?>
        </div>
        <?php snippet('footer') ?>