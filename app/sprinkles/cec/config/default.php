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
        'timezone' => 'America/Chicago',
        'log_errors' => true
    ],
    'debug' => [
        'smtp' => true,
        'queries' => true,
        'ajax' => true
    ],
    'mail' => [
        'mailer' => 'smtp', // Set to one of 'smtp', 'mail', 'qmail', 'sendmail'
        'host' => getenv('SMTP_HOST') ?: null,
        'port' => 587,
        'auth' => true,
        'secure' => 'tls',
        'username' => getenv('SMTP_USER') ?: null,
        'password' => getenv('SMTP_PASSWORD') ?: null,
        'smtp_debug' => 4,
        'message_options' => [
            'CharSet' => 'UTF-8',
            'isHtml' => true,
            'Timeout' => 15
        ]
    ]
];
