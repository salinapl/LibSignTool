<?php

use Kirby\Toolkit\Str;

Kirby::plugin('salinapl/libsigntool', [
    'blueprints' => [
        'fields/lst-links' => __DIR__ . '/blueprints/links.yml',
        'files/image' => __DIR__ . '/blueprints/image.yml',
        'files/video' => __DIR__ . '/blueprints/video.yml',
        'pages/lst-slideshows' => __DIR__ . '/blueprints/slideshows.yml',
        'pages/lst-slideshow' => __DIR__ . '/blueprints/slideshow.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal2.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/goal.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/events.yml',
        'pages/web-slides' => __DIR__ . '/blueprints/error-slide.yml',
        'pages/lst-gallery' => __DIR__ . '/blueprints/gallery.yml',
        'pages/videogalleries' => __DIR__ . '/blueprints/videogallery.yml'

    ],
    'controllers' => [
        'slideshow' => require __DIR__ . '/controllers/slideshow.php'
    ],
    'templates' => [
        'lst-error-slide' => __DIR__ . '/templates/error-slide.php',
        'lst-events' => __DIR__ . '/templates/events.php',
        'lst-goal' => __DIR__ . '/templates/goal.php',
        'lst-goal2' => __DIR__ . '/templates/goal2.php',
        'lst-opac' => __DIR__ . '/templates/opac.php',
        'lst-slideshow' => __DIR__ . '/templates/slideshow.php',
        'lst-slideshows' => __DIR__ . '/templates/slideshows.php'
    ],
    'snippets' => [
        'lst-builder' => __DIR__ . '/snippets/builder.php',
        'lst-event' => __DIR__ . '/snippets/event.php',
        'lst-footer' => __DIR__ . '/snippets/footer.php',
        'lst-header' => __DIR__ . '/snippets/header.php'
    ],
    'options' => [
        // checks for landscape or portrait tag in URL
        'routes' => [
            [
            'pattern' => 'slideshows/(:any)/(:any)',
            'action' => function ($subpage, $orientation) {
                $data = [
                    'orientation' => $orientation,
                ];
                return page('slideshows/' . $subpage)?->render($data);
            }
            ]
        ]
    ],
    'fields' => [
        'slideshowSelect' => [
            'extends' => 'select',
            'props' => [
                // Kirby calls this to build your <select> options
                'options' => function (): array {
                    $page = site()->find('slideshows');
                    return $page
                        ? $page->children()->pluck('title', 'id')
                        : [];
                }
            ]
        ]
    ],
    'hooks' => [
        // fires after plugins are registered
        'system.loadPlugins:after' => function () {
            $kirby = kirby();
            $page = 'slideshows';
            if ($kirby->page($page)?->exists()) {
                return;
            }

            // create the page
            $kirby->impersonate(
                'kirby',
                fn () => $kirby->site()->createChild([
                    'slug' => $page,
                    'template' => 'slideshows',
                    'content' => [
                        'uuid' => $page,
                    ]
                ])->changeStatus('unlisted')
            );
        }
    ]
        // plugin magic happens here
]);