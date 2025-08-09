<?php

use Kirby\Cms\App;
use Kirby\Toolkit\Str;
use Kirby\Data\Yaml;

Kirby::plugin('salinapl/libsigntool', [
    'blueprints' => [
        'fields/lst-times' => __DIR__ . '/blueprints/lst-times.yml',
        'fields/lst-tags' => __DIR__ . '/blueprints/lst-tags.yml',
        'files/lst-slide' => __DIR__ . '/blueprints/lst-slide.yml',
        'pages/lst-placeholder' => __DIR__ . '/blueprints/lst-placeholder.yml',
        'pages/lst-slideshows' => __DIR__ . '/blueprints/slideshows.yml',
        'pages/lst-slideshow' => __DIR__ . '/blueprints/slideshow.yml',
        'pages/lst-web-goal-bar' => __DIR__ . '/blueprints/lst-web-goal-bar.yml',
        'pages/lst-web-goal-img' => __DIR__ . '/blueprints/lst-web-goal-img.yml',
        'pages/lst-web-events' => __DIR__ . '/blueprints/lst-web-events.yml',
        'pages/lst-web-error' => __DIR__ . '/blueprints/lst-web-error.yml',
        'pages/lst-opac' => __DIR__ . '/blueprints/lst-opac.yml',
        'pages/lst-gallery' => __DIR__ . '/blueprints/lst-gallery.yml',

    ],
    'controllers' => [
        'lst-slideshow' => require __DIR__ . '/controllers/slideshow.php',
        'lst-web-events' => require __DIR__ . '/controllers/lst-web-events.php'
    ],
    'templates' => [
        'lst-web-error' => __DIR__ . '/templates/lst-web-error.php',
        'lst-web-events' => __DIR__ . '/templates/lst-web-events.php',
        'lst-web-goal-bar' => __DIR__ . '/templates/lst-web-goal-bar.php',
        'lst-web-goal-img' => __DIR__ . '/templates/lst-web-goal-img.php',
        'lst-opac' => __DIR__ . '/templates/lst-opac.php',
        'lst-slideshow' => __DIR__ . '/templates/slideshow.php',
        'lst-slideshows' => __DIR__ . '/templates/slideshows.php'
    ],
    'snippets' => [
        'lst-layout' => __DIR__ . '/snippets/lst-layout.php',
        'lst-web-event-js' => __DIR__ . '/snippets/lst-web-event-js.php',
        'lst-web-event-php' => __DIR__ . '/snippets/lst-web-event-php.php',
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
            $webslideSlug = 'web-slide-error';

            // Check if slideshows exists, create if not
            if (! $kirby->page($parentSlug)?->exists()) {
                $kirby->impersonate('kirby', fn() =>
                    $kirby->site()->createChild([
                        'slug'     => $parentSlug,
                        'template' => 'lst-placeholder',
                        'content'  => [
                            'uuid' => $parentSlug,
                        ]
                    ])->changeStatus('unlisted')
                );
            }
            
            $webslidePath = "$parentSlug/$webslideSlug";

            // Check if web-slides exists, create if not
            if (! $kirby->page($webslidePath)?->exists()) {
                $body = <<<'EOT'
        No active slides were found. Please contact staff in charge of digital signage to resolve the issue.
        - Check that all Campaigns are not expired.
        - Check Selected Campaign tags to make sure active Campaigns are not excluded.
        EOT;
                $kirby->impersonate('kirby', fn() =>
                $kirby->page($parentSlug)->createChild([
                    'slug'     => $webslideSlug,
                    'template' => 'lst-web-error',
                    'content'  => [
                            'uuid'     => $webslideSlug,
                            'title'    => 'Error Slide',
                            'icon'     => 'ri-error-warning-fill',
                            'headline' => 'No Active Slides Set',
                            'body'     => $body,
                    ]
                ])->changeStatus('unlisted')
            );
            }
            if ($kirby->page($webslidePath)?->exists()) {
                    $result = $kirby->impersonate('kirby', function() {
                        page('slideshows')->changeTemplate('lst-slideshows');

                        return;
                    });
            }
        }
    ]
]);
