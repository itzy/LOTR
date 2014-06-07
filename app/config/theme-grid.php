<?php
/**
 * Config-file for Anax, theme related settings, return it all as array.
 *
 */
return [

    /**
     * Settings for Which theme to use, theme directory is found by path and name.
     *
     * path: where is the base path to the theme directory, end with a slash.
     * name: name of the theme is mapped to a directory right below the path.
     */
    'settings' => [
        'path' => ANAX_INSTALL_PATH . 'theme/',
        'name' => 'itzy-grid',
    ],


    /**
     * Add default views.
     */
    'views' => [
        [
            'region'   => 'header',
            'template' => 'me/header',
            'data'     => [
                'siteTitle' => "Min me-sida i PHPMVC",
                'siteTagline' => "Ramverk modifierat av Julia Sivartsson",
            ],
            'sort'     => -1
        ],
        ['region' => 'footer', 'template' => 'me/footer', 'data' => [], 'sort' => -1],

        [
            'region' => 'navbar',
            'template' => [
                'callback' => function() {
                        return $this->di->navbar->create();
                    },
            ],
            'data' => [],
            'sort' => -1
        ],
    ],

    /**
     * Data to extract and send as variables to the main template file.
     */
    'data' => [

        // Language for this page.
        'lang' => 'sv',

        // Append this value to each <title>
        'title_append' => ' | itzy a web template',

// Stylesheets
//'stylesheets' => ['css/style.css', 'css/navbar_me.css'],
        'stylesheets' => ['css/itzy-grid/style.php'],

        // Inline style
        'style' => null,

        // Favicon
        'favicon' => 'bird.png',

        // Path to modernizr or null to disable
        'modernizr' => 'js/modernizr.js',

        // Path to jquery or null to disable
        'jquery' => '',

        // Array with javscript-files to include
        'javascript_include' => ['/js/test.js'],

        // Use google analytics for tracking, set key or null to disable
        'google_analytics' => null,
    ],
];

