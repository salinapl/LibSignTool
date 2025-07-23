<?php $url = $_SERVER['REQUEST_URI']; ?>
<?php snippet('lst-header') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/flickity.min.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/slideshow.css') ?>
    </head>
    <body>
        <?php if(preg_match('/portrait|landscape/i', $url)):  ?>
            <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "autoPlay": <?= $page->delay() ?>, "pauseAutoPlayOnHover": false, "wrapAround": true, "imagesLoaded": true, "pageDots": false, "prevNextButtons": false}'>
            
            <?php snippet('lst-builder') ?>
            </div>
        <?php else: ?>
            <script>
                if (window.matchMedia("(orientation: portrait)").matches) {
                    // you're in PORTRAIT mode
                    window.location.replace("<?= page($page->defaults())->url() ?>/portrait");
                }

                if (window.matchMedia("(orientation: landscape)").matches) {
                    // you're in LANDSCAPE mode
                    window.location.replace("<?= page($page->defaults())->url() ?>/landscape");
                }
            </script>
        <?php endif ?>
        <?php snippet('lst-footer') ?>
