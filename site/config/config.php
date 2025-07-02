<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen. 
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
return [
  /*checks for landscape or portrait tag in URL*/
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
  ],
  /* For security, turn to FALSE when going live */
  'debug' => false,
  'panel' =>[
    'install' => false,
    'vue' => [
            'compiler' => false
        ]
  ]
];
