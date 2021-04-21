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
    [
        'text' => 'listClients',
        // 'url'  => '#',
        'route'  => 'client::list',
        'icon' => 'fa fa-users',
    ],
    [
        'text'    => 'documents',
        'icon'    => 'fas fa-copy',
        'submenu' => [
            [
                'text' => 'quotes',
                'url'  => '#',
                'icon' => 'fa fa-clipboard-list',
                // 'route' => ['doc::list', ['X']],
            ],
            [
                'text' => 'orders',
                'url'  => '#',
                'icon' => 'fa fa-file-invoice',
                // 'route' => ['doc::list', ['X']],
            ],
            [
                'text' => 'ddt',
                'url'  => '#',
                'icon' => 'fa fa-truck-loading',
                // 'route' => ['doc::list', ['X']],                
            ],
            [
                'text' => 'invoice',
                'url'  => '#',
                'icon' => 'fa fa-file-invoice-dollar',
                // 'route' => ['doc::list', ['X']],
            ],
        ],
    ],
    [
        'text' => 'products',
        'url'  => '#',
        // 'route' => ['doc::list', ['X']],
        'icon' => 'fa fa-boxes',
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
