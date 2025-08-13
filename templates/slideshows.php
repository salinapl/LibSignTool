<?php snippet('lst-layout', slots: true) ?>
  <?php slot('lstHeader') ?>
  <?php if (!get('orientation')): ?>
      <script>
          window.addEventListener('load', () => {
              const base = "<?= page($page->defaults())->url() ?>";
              const orientation = window.matchMedia("(orientation: portrait)").matches 
              ? "portrait" 
              : "landscape";
              window.location.replace(base + `?orientation=${orientation}`);
          });
      </script>
      <?php exit; ?>
  <?php endif ?>
  <?php endslot() ?>
<?php endsnippet() ?>
