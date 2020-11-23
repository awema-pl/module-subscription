<?php

return [
    'merge_to_navigation' => true,

    'navs' => [
        'sidebar' =>[

        ],
        'adminSidebar' =>[
            [
                'name' => 'Subscriptions',
                'link' => '/admin/subscription/options',
                'icon' => 'speed',
                'permissions' => 'manage_subscriptions',
                'key' => 'subscription::menus.subscriptions',
                'children_top' => [
                    [
                        'name' => 'Options',
                        'link' => '/admin/subscription/options',
                        'key' => 'subscription::menus.options',
                    ],
                    [
                        'name' => 'Memberships',
                        'link' => '/admin/subscription/memberships',
                        'key' => 'subscription::menus.memberships',
                    ]
                ],
                'children' => [
                    [
                        'name' => 'Options',
                        'link' => '/admin/subscription/options',
                        'key' => 'subscription::menus.options',
                    ],
                    [
                        'name' => 'Memberships',
                        'link' => '/admin/subscription/memberships',
                        'key' => 'subscription::menus.memberships',
                    ]
                ],
            ]
        ]

    ]
];
