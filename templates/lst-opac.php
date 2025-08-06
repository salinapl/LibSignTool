<?php snippet('lst-header') ?>
        <?= css('/media/plugins/salinapl/libsigntool/fonts/remixicon.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/flickity.min.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/opac.css') ?>
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
                <div class="main-carousel">
                    <iframe class="carousel-cell" src="<?= $page->slideshow()->url() ?>" scrolling="no"></iframe>
                </div>
            <?php endif ?>
        </div>
        <?php snippet('lst-footer') ?>