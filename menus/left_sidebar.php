<?php

$leftSidebar = [
    [
        'text'        => 'Home',
        'url'         => 'home',
        'icon'        => 'fas fa-fw fa-home',
        'label'       => 4,
        'label_color' => 'success',
    ],
    ['header' => 'account_settings'],
    [
        'text' => 'profile',
        'url'  => 'admin/settings',
        'icon' => 'far fa-fw fa-user',
    ],
    [
        'text' => 'change_password',
        'url'  => 'admin/settings',
        'icon' => 'fas fa-fw fa-lock',
    ],
    [
        'text'    => 'multilevel',
        'icon'    => 'fas fa-fw fa-share',
        'submenu' => [
            [
                'text' => 'level_one',
                'url'  => '#',
            ],
            [
                'text'    => 'level_one',
                'url'     => '#',
                'submenu' => [
                    [
                        'text' => 'level_two',
                        'url'  => '#',
                    ],
                    [
                        'text'    => 'level_two',
                        'url'     => '#',
                        'submenu' => [
                            [
                                'text' => 'level_three',
                                'url'  => '#',
                            ],
                            [
                                'text' => 'level_three',
                                'url'  => '#',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'text' => 'level_one',
                'url'  => '#',
            ],
        ],
    ],
    ['header' => 'labels'],
    [
        'text'       => 'important',
        'icon_color' => 'red',
        'url'        => '#',
    ],
    [
        'text'       => 'warning',
        'icon_color' => 'yellow',
        'url'        => '#',
    ],
    [
        'text'       => 'information',
        'icon_color' => 'cyan',
        'url'        => '#',
    ],
];
