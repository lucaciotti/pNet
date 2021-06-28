<?php

$leftSidebar = [
    [
        'text'        => 'Home',
        'url'         => 'home',
        'icon'        => 'fas fa-fw fa-home',
        // 'label'       => 4,
        // 'label_color' => 'success',
    ],
    [
        'header' => 'main_header',
        'classes'  => 'text-bold text-center',
    ],
    // [ ==> Spostato in AppServiceProvider
    //     'text' => 'listClients',
    //     // 'url'  => '#',
    //     'route'  => 'client::list',
    //     'icon' => 'fa fa-users',
    // ],
    [
        'key'     => 'documents',
        'text'    => 'documents',
        'icon'    => 'fas fa-copy',
        'submenu' => [
            [
                'text' => 'quotes',
                // 'url'  => '#',
                'icon' => 'fa fa-clipboard-list',
                'route' => ['doc::list', ['P']],
            ],
            [
                'text' => 'orders',
                // 'url'  => '#',
                'icon' => 'fa fa-file-invoice',
                'route' => ['doc::list', ['O']],
            ],
            [
                'text' => 'ddt',
                // 'url'  => '#',
                'icon' => 'fa fa-truck-loading',
                'route' => ['doc::list', ['B']],                
            ],
            [
                'text' => 'invoice',
                // 'url'  => '#',
                'icon' => 'fa fa-file-invoice-dollar',
                'route' => ['doc::list', ['F']],
            ],
        ],
    ],
    [
        'text' => 'products',
        // 'url'  => '#',
        'route' => 'product::list',
        'icon' => 'fa fa-boxes',
    ],

    [
        'header' => 'tutorial_header',
        'classes'  => 'text-bold text-center',
    ],
    [
        'text' => 'videoLink',
        'url'  => 'https://www.youtube.com/playlist?list=PLpD2hglxlx_elO_RsO9Vk2dnzir5dkPss',
        'icon' => 'fa fa-youtube',
        'target' => '_blank'
    ],
    
    // ['header' => 'labels'],
    // [
    //     'text'       => 'important',
    //     'icon_color' => 'red',
    //     'url'        => '#',
    // ],
    // [
    //     'text'       => 'warning',
    //     'icon_color' => 'yellow',
    //     'url'        => '#',
    // ],
    // [
    //     'text'       => 'information',
    //     'icon_color' => 'cyan',
    //     'url'        => '#',
    // ],
];
