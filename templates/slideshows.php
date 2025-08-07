<?php snippet('lst-header') ?>
<?php
$orientation = get('orientation');
if (!$orientation && !isset($_GET['tried'])): ?>
    <script>
        const base = "<?= page($page->defaults())->url() ?>";
        const orientation = window.matchMedia("(orientation: portrait)").matches ? "portrait" : "landscape";
        window.location.replace(base + "?orientation=" + orientation + "&tried=1");
  </script>
  <?php exit; ?>
<?php endif ?>
<?php snippet('lst-footer') ?>
