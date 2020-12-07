<?php
return [
    // this resources has been auto load to layout
    'dist' => [
        'js/main.js',
        'js/main.legacy.js',
        'css/main.css',
    ],
    'routes' => [
        // all routes is active
        'active' => true,
        // section installations
        'installation' => [
            'active' => true,
            'prefix' => '/installation/subscription',
            'name_prefix' => 'subscription.installation.',
            // this routes has beed except for installation module
            'expect' => [
                'module-assets.assets',
                'subscription.installation.index',
                'subscription.installation.store',
            ]
        ],
        'option' => [
            'active' => true,
            'prefix' => '/admin/subscription/options',
            'name_prefix' => 'subscription.option.',
            'middleware' => [
                'web',
                'auth',
                'can:manage_options'
            ]
        ],
        'membership'=>[
            'active' => true,
            'prefix' => '/admin/subscription/memberships',
            'name_prefix' => 'subscription.membership.',
            'middleware' => [
                'web',
                'auth',
                'can:manage_memberships'
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Use permissions in application.
    |--------------------------------------------------------------------------
    |
    | This permission has been insert to database with migrations
    | of module permission.
    |
    */
    'permissions' =>[
        'install_packages', 'manage_options', 'manage_memberships'
    ],

    /*
    |--------------------------------------------------------------------------
    | Can merge permissions to module permission
    |--------------------------------------------------------------------------
    */
    'merge_permissions' => true,

    'installation' => [
        'auto_redirect' => [
            // user with this permission has been automation redirect to
            // installation package
            'permission' => 'install_packages'
        ]
    ],

    'database' => [
        'tables' => [
            'users' => 'users', // table users of laravel appliaction
            'options' =>'subscription_options',
            'memberships' => 'subscription_memberships',
        ],
        'insert_options' =>[
            [
                'name' => 'Standard',
                'price' => 26.00
            ],
            [
                'name' => 'Premium',
                'price' => 38.00
            ],
            [
                'name' => 'VIP',
                'price' => 54.00
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Use trial
    |--------------------------------------------------------------------------
    |
    | Add option "Trial" to database and auto create membership for register
    | user.
    |
    */
    'use_trial' =>'true',

    'trial_option_name' =>'Trial',

    'trial_days' =>14,
];
