<?php snippet('lst-layout', slots: true) ?>
    <?php slot('lstHeader') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/event.css') ?>
    <?php endslot() ?>
    <?php slot() ?>
        <h1><?= $page->headline() ?></h1>
        <?php snippet('lst-web-event-php') ?>
    <?php endslot() ?>
<?php endsnippet() ?>
