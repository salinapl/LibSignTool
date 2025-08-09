<?php snippet('lst-layout', slots: true) ?>
    <?php slot('lstHeader') ?>
        <?= css('/media/plugins/salinapl/libsigntool/fonts/remixicon.css') ?>
        <?= css('/media/plugins/salinapl/libsigntool/css/templates/error-slide.css') ?>
    <?php endslot() ?>
    <?php slot() ?>
        <div class="flex-box">
            <div class="flex-item">
                <h1><i class="<?= $page->icon() ?>"></i><?= $page->headline() ?></h1>
                <?= $page->body()->kirbytext() ?>
            </div>
        </div>
    <?php endslot() ?>
<?php endsnippet() ?>
