<?php

namespace common\models\form\WriterSubscribe;

use common\models\Subscriber;
use yii\helpers\ArrayHelper;

class EmailWriterSubscribeForm extends WriterSubscribeForm
{
    public $email;
    protected $contactFieldName = 'email';

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [$this->contactFieldName, 'email'],
        ]);
    }

    public function attributeLabels()
    {
        return [
            $this->contactFieldName => 'Email',
        ];
    }

    public function getSubscriberByContactFieldName(): ?Subscriber
    {
        return Subscriber::find()->byEmail($this->{$this->contactFieldName})->one();
    }
}