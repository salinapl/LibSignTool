<?php snippet('header') ?>
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
<?php snippet('footer') ?>
