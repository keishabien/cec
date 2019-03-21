<?php

/**
 * Sample site configuration file for UserFrosting.  You should definitely set these values!
 *
 */
return [
    'address_book' => [
        'admin' => [
            'name' => 'Keisha'
        ]
    ],
    'site' => [
        'author' => 'Keisha Bien',
        'title' => 'CEC',
        'logo' => 'assets/images/login_cec.jpg',
        'registration' => [
            'enabled' => false,
            'user_defaults' => [
                'group' => 'midwest'
            ]
        ]
    ],
    'php' => [
        'timezone' => 'America/Chicago'
    ]
];
