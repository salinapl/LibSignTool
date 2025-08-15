<?php snippet('lst-layout', slots: true) ?>
    <?php slot('lstHeader') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/flickity.min.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/slideshow.css') ?>
        <?php if (!get('orientation')): ?>
            <script>
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        const orientation = window.matchMedia("(orientation: portrait)").matches 
                        ? "portrait" 
                        : "landscape";
                        window.location.replace(`<?= $page->url() ?>?orientation=${orientation}`);
                    }, 2000); // 2 second delay to allow page to paint and settle
                });
            </script>
            <?php exit; ?>
        <?php endif ?>
    <?php endslot() ?>
    <?php slot() ?>
        <div class="main-carousel" data-flickity='{ "autoPlay": <?= $delay ?>, "cellAlign": "left", "imagesLoaded": true, "pageDots": false, "pauseAutoPlayOnHover": false, "prevNextButtons": false, "wrapAround": true}'>
            <?= implode("\n", $slides) ?>
        </div>
    <?php endslot() ?>
    <?php slot('lstSlide') ?>
    <?php endslot() ?>
<?php endsnippet() ?>
