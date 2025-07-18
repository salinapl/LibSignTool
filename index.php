<?php

Kirby::plugin('salinapl/libsigntool', [
    'blueprints' => [
        'fields/links' => __DIR__ . '/blueprints/links.yml',
        'files/image' => __DIR__ . '/blueprints/image.yml',
        'files/video' => __DIR__ . '/blueprints/video.yml',
        'pages/slideshows' => __DIR__ . '/blueprints/slideshows.yml',
        'pages/slideshow' => __DIR__ . '/blueprints/slideshow.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal2.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/events.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/error-slide.yml',
        'pages/galleries' => __DIR__ . '/blueprints/gallery.yml',
        'pages/videogalleries' => __DIR__ . '/blueprints/videogallery.yml'

    ],
    'controllers' => [
        'slideshow' => require __DIR__ . '/controllers/slideshow.php'
    ],
    'templates' => [
        'error-slide' => __DIR__ . '/templates/error-slide.php',
        'events' => __DIR__ . '/templates/events.php',
        'goal' => __DIR__ . '/templates/goal.php',
        'goal2' => __DIR__ . '/templates/goal2.php',
        'opac' => __DIR__ . '/templates/opac.php',
        'slideshow' => __DIR__ . '/templates/slideshow.php',
        'slideshows' => __DIR__ . '/templates/slideshows.php'
    ],
    'snippets' => [
        'builder' => __DIR__ . '/snippets/builder.php',
        'event' => __DIR__ . '/snippets/event.php',
        'footer' => __DIR__ . '/snippets/footer.php',
        'header' => __DIR__ . '/snippets/header.php'
    ]
        // plugin magic happens here
]);