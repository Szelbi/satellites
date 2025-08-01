<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => 'js/app.js',
        'entrypoint' => true,
    ],
    'satellites' => [
        'path' => 'js/satellites.js',
        'entrypoint' => true,
    ],
    'lucky_number' => [
        'path' => 'js/lucky_number.js',
        'entrypoint' => true,
    ],
    'todo' => [
        'path' => 'js/todo.js',
        'entrypoint' => true,
    ],
    'sidebar' => [
        'path' => 'js/sidebar.js',
        'entrypoint' => true,
    ],
    'weather' => [
        'path' => 'js/weather.js',
        'entrypoint' => true,
    ],
    'jquery' => [
        'version' => '3.7.1',
    ],
    'bootstrap' => [
        'version' => '5.3.7',
    ],
    '@popperjs/core' => [
        'version' => '2.11.8',
    ],
    'bootstrap/dist/css/bootstrap.min.css' => [
        'version' => '5.3.7',
        'type' => 'css',
    ],
    'bootstrap-icons/font/bootstrap-icons.min.css' => [
        'version' => '1.13.1',
        'type' => 'css',
    ],
];
