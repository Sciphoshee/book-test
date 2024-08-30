<?php

namespace common\models\form\WriterSubscribe;

use common\helpers\StringHelper;
use common\models\Subscriber;
use common\validators\PhoneValidator;
use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;


class PhoneWriterSubscribeForm extends WriterSubscribeForm
{
    public $phone;
    protected $contactFieldName = 'phone';

    public function beforeValidate(): bool
    {
        if ($this->phone) {
            $this->phone = StringHelper::onlyInt($this->phone);
        }

        return parent::beforeValidate();
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [$this->contactFieldName, PhoneValidator::class],
        ]);
    }

    public function attributeLabels()
    {
        return [
            $this->contactFieldName => 'Номер телефона',
        ];
    }

    public function renderSubscribeActiveFormField(ActiveForm $form): ActiveField
    {
        return parent::renderSubscribeActiveFormField($form)
            ->widget(\yii\widgets\MaskedInput::class, ['mask' => '+9 (999) 999-99-99']);
    }

    public function getSubscriberByContactFieldName(): ?Subscriber
    {
        return Subscriber::find()->byPhone($this->{$this->contactFieldName})->one();
    }
}