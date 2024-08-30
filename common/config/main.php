<?php

use common\components\BookWritersSubscribersNotifier;
use common\fabric\WriterSubscribe\PhoneWriterSubscribeFabric;
use common\fabric\WriterSubscribe\WriterSubscribeFabricInterface;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\form\WriterSubscribe\PhoneWriterSubscribeForm;
use common\models\form\WriterSubscribe\EmailWriterSubscribeForm;
use repositories\BookRepositoryInterface;
use repositories\Yii2ArBookRepository;
use services\BookService;
use yii\di\Container;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'bookWritersSubscribersNotifier'
    ],
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'cache' => [
//            'class' => \yii\caching\FileCache::class,
            'class' => \yii\caching\DummyCache::class,
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8mb4',

            'enableLogging' => true,
            'enableProfiling' => true,
        ],
        'smsProvider' => [
            'class' => \common\components\SmsPilot::class,
            'baseUrl' => env('SMS_PILOT_API_BASE_URL'),
            'apiKey' => env('SMS_PILOT_API_KEY'),
            'fromName' => env('SMS_PILOT_SENDER', 'INFORM'),
        ],
        'bookWritersSubscribersNotifier' => BookWritersSubscribersNotifier::class,
//        'bookService' => [
//            'class' => BookService::class,
//        ],
    ],
    'container' => [
        'definitions' => [
            WriterSubscribeFormInterface::class => PhoneWriterSubscribeForm::class,
            //ИЛИ
//            WriterSubscribeInterface::class => WriterSubscribeEmailForm::class,

            WriterSubscribeFabricInterface::class => PhoneWriterSubscribeFabric::class,

            BookRepositoryInterface::class => Yii2ArBookRepository::class,
            BookService::class => function (Container $container) {
                return new BookService(
                    $container->get(BookRepositoryInterface::class)
                );
            },
        ],
//            'singletons' => [
//                BookService::class => [
//                    BookRepositoryInterface::class => Yii2ArBookRepository::class,
//                ],
//            ]
    ]
];
