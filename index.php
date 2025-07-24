<?php

use Kirby\Cms\App;
use Kirby\Toolkit\Str;
use Kirby\Data\Yaml;

Kirby::plugin('salinapl/libsigntool', [
    'blueprints' => [
        'fields/lst-links' => __DIR__ . '/blueprints/links.yml',
        'files/image' => __DIR__ . '/blueprints/image.yml',
        'files/video' => __DIR__ . '/blueprints/video.yml',
        'pages/lst-slideshows' => __DIR__ . '/blueprints/slideshows.yml',
        'pages/lst-slideshow' => __DIR__ . '/blueprints/slideshow.yml',
        'pages/lst-webslide' => __DIR__ . '/blueprints/lst-webslide.yml',
        'pages/lst-web-goal' => __DIR__ . '/blueprints/goal.yml',
        'pages/lst-web-goal2' => __DIR__ . '/blueprints/goal2.yml',
        'pages/lst-web-events' => __DIR__ . '/blueprints/events.yml',
        'pages/lst-web-error' => __DIR__ . '/blueprints/error-slide.yml',
        'pages/lst-opac' => __DIR__ . '/blueprints/opac.yml',
        'pages/lst-gallery' => __DIR__ . '/blueprints/gallery.yml',
        'pages/videogalleries' => __DIR__ . '/blueprints/videogallery.yml'

    ],
    'controllers' => [
        'slideshow' => require __DIR__ . '/controllers/slideshow.php'
    ],
    'templates' => [
        'lst-web-error' => __DIR__ . '/templates/error-slide.php',
        'lst-web-events' => __DIR__ . '/templates/events.php',
        'lst-web-goal' => __DIR__ . '/templates/goal.php',
        'lst-web-goal2' => __DIR__ . '/templates/goal2.php',
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
            $parentSlug = 'slideshows';
            $webslideSlug = 'web-slide';
            $errorSlug = 'error-slide';

            // Check if slideshows exists, create if not
            if (! $kirby->page($parentSlug)?->exists()) {
                $kirby->impersonate('kirby', fn() =>
                    $kirby->site()->createChild([
                        'slug'     => $parentSlug,
                        'template' => 'lst-slideshows',
                        'content'  => [
                            'uuid' => $parentSlug
                        ]
                    ])->changeStatus('unlisted')
                );
            }
            
            $webslidePath = "$parentSlug/$webslideSlug";

            // Check if web-slides exists, create if not
            if (! $kirby->page($webslidePath)?->exists()) {
                $kirby->impersonate('kirby', fn() =>
                $kirby->page($parentSlug)->createChild([
                    'slug'     => $webslideSlug,
                    'content'  => [
                        'uuid'     => $webslideSlug,
                    ]
                ])->changeStatus('unlisted')
                );
            }

            $errorPath = "$parentSlug/$webslideSlug/$errorSlug";

            // Check if error-slide exists, create if not
            if (! $kirby->page($errorPath)?->exists()) {
                $body = <<<'EOT'
        No active slides were found. Please contact staff in charge of digital signage to resolve the issue.
        - Check that all Campaigns are not expired.
        - Check Selected Campaign tags to make sure active Campaigns are not excluded.
        EOT;

                $kirby->impersonate('kirby', fn() =>
                $kirby->page($webslidePath)->createChild([
                    'slug'     => $errorSlug,
                    'template' => 'lst-web-error',
                    'content'  => [
                        'uuid'     => $errorSlug,
                        'icon'     => 'ri-error-warning-fill',
                        'headline' => 'No Active Slides Set',
                        'body'     => $body
                    ]
                ])->changeStatus('unlisted')
                );
            }
        }
    ]
        // plugin magic happens here
]);