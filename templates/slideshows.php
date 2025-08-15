<?php snippet('lst-layout', slots: true) ?>
<?php slot('lstHeader') ?>
<?php if (!get('orientation')): ?>
    <script>
        window.addEventListener('load', () => {
            setTimeout(() => {
                const base = "<?= page($page->defaults())->url() ?>";
                const orientation = window.matchMedia("(orientation: portrait)").matches 
                ? "portrait" 
                : "landscape";
                window.location.replace(base + `?orientation=${orientation}`);
            }, 2000); // 2 second delay to allow page to paint and settle
        });
    </script>
    <?php exit; ?>
<?php endif ?>
<?php endslot() ?>
<?php endsnippet() ?>
