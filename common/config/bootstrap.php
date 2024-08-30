<?php

use common\models\Book;
use yii\base\Event as Event;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@services', dirname(dirname(__DIR__)) . '/services');
Yii::setAlias('@entities', dirname(dirname(__DIR__)) . '/entities');
Yii::setAlias('@repositories', dirname(dirname(__DIR__)) . '/repositories');


Event::on(Book::class, Book::EVENT_PUBLISH, function ($event) {
    $notifier = Yii::$app->bookWritersSubscribersNotifier;
    $notifier->notify($event->sender);
});