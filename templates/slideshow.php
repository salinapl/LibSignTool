<?php
$orientation = get('orientation');
if (!$orientation && !isset($_GET['tried'])): ?>
    <script>
        const base = "<?= $page->url() ?>";
        const orientation = window.matchMedia("(orientation: portrait)").matches ? "portrait" : "landscape";
        window.location.replace(base + "?orientation=" + orientation + "&tried=1");
  </script>
  <?php exit; ?>
<?php endif ?>
<?php snippet('lst-header') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/flickity.min.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/slideshow.css') ?>
    </head>
    <body>
        <div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "autoPlay": <?= $delay ?>, "pauseAutoPlayOnHover": false, "wrapAround": true, "imagesLoaded": true, "pageDots": false, "prevNextButtons": false}'>
            <?= implode("\n", $slides) ?>
        </div>
        <?php snippet('lst-footer') ?>
