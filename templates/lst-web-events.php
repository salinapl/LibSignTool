<?php snippet('lst-layout', slots: true) ?>
    <?php slot('lstHeader') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/event.css') ?>
    <?php endslot() ?>
    <?php slot() ?>
        <?php snippet('lst-web-event-js') ?>
    <?php endslot() ?>
<?php endsnippet() ?>
