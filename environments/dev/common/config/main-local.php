<?php

$config = [
    'bootstrap' => [
        'debug',
        'bookWritersSubscribersNotifier'
    ],
    'components' => [
//        'db' => [
//            'class' => \yii\db\Connection::class,
//            'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
//            'username' => 'root',
//            'password' => '',
//            'charset' => 'utf8',
//        ],

        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            // You have to set
            //
            // 'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
            //    'transport' => [
            //        'scheme' => 'smtps',
            //        'host' => '',
            //        'username' => '',
            //        'password' => '',
            //        'port' => 465,
            //        'dsn' => 'native://default',
            //    ],
            //
            // DSN example:
            //    'transport' => [
            //        'dsn' => 'smtp://user:pass@smtp.example.com:25',
            //    ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] =
        [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*'],
        ];

    $config['bootstrap'][] = 'log';
    $config['components']['log'] = [
        'targets' => [
            [
                'class' => 'yii\log\DbTarget',
                'levels' => ['error', 'warning'],
            ],
        ],
    ];
}

if (!YII_ENV_PROD) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;