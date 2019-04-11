<?php

/**
 * Sample site configuration file for UserFrosting.  You should definitely set these values!
 *
 */
return [
    'address_book' => [
        'admin' => [
            'email' => 'webhost@midwest-dental.com',
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
        'timezone' => 'America/Chicago',
        'log_errors' => true
    ],
    'debug' => [
        'smtp' => true,
        'queries' => true,
        'ajax' => true
    ],
    'mail' => [
        'mailer' => 'mail',
        'host' => 'localhost',
        'port' => 25,
        'auth' => false,
        /**        'secure' => '',
         * 'username' => getenv('SMTP_USER') ?: null,
         * 'password' => getenv('SMTP_PASSWORD') ?: null,
         */
        'smtp_debug' => 3,
        'message_options' => [
            'CharSet' => 'UTF-8',
            'isHtml' => true
        ]
    ]
];
