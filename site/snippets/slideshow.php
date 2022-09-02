<?php 
    $gallery = page($page->gallery())->images();
    $gallery = $gallery->filterBy('tags', 'in', $page->tags()->split(','), ',');

// <?php if ($page->parent()->title() = "OPAC Pages") {
//     $gallery = page($slides)->gallery()->images();
//     $tags = page($slides->tags());
// } else {
//     $gallery = page($page->gallery())->images();
//     $tags = page($page->tags());
// }

// orientation variable MUST be passed by snippet
?>

<?php foreach ($gallery->sortBy('sort','asc') as $image): ?>
    <!-- filter for only images that are supposed to be visible -->
    <?php if (($image->expire()->toDate('Y-m-d') > date('Y-m-d')) && ($image->start()->toDate('Y-m-d') <= date('Y-m-d'))): ?>
        <!-- match orientation to image -->
        <?php if($image->orientation() == $orientation): ?>
            <?php if($image->orientation() == 'portrait'): ?>
                <a 
                <?php if ($image->link()->isNotEmpty()): ?>
                    href="<?= $image->link()->url(); ?>"
                <?php endif ?>
                class="carousel-cell ad" style="background-image:url(<?= $image->resize(null, 1080)->url() ?>)">
            <?php else: ?>
                <a class="carousel-cell ad" style="background-image:url(<?= $image->resize(1080, null)->url() ?>)">
            <?php endif ?>
                </a>
        <?php endif ?>
    <?php endif ?>
<?php endforeach ?>