<?php
/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',

    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home'  => [
            'text'  => 'index',
            'url'   => '',
            'title' => 'All about LOTR'
        ],


        // This is a menu item
        'questions     ' => [
            'text'  =>'questions',
            'url'   =>'questions/listAll',
            'title' => 'questions'
        ],

        // This is a menu item
        'tags     ' => [
            'text'  =>'tags',
            'url'   =>'tag/list',
            'title' => 'tags'
        ],

        // This is a menu item
        'users     ' => [
            'text'  =>'users',
            'url'   =>'users/list',
            'title' => 'users'
        ],

        // This is a menu item
        'about     ' => [
            'text'  =>'about',
            'url'   =>'about',
            'title' => 'about'
        ],

    ],

    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
            if ($url == $this->di->get('request')->getRoute()) {
                return true;
            }
        },

    // Callback to create the urls
    'create_url' => function($url) {
            return $this->di->get('url')->create($url);
        },
];
