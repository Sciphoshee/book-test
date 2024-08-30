<?php

namespace common\validators;

use common\helpers\StringHelper;
use yii\validators\Validator;

class PhoneValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $phoneInt = StringHelper::onlyInt($model->$attribute);

        if (!$phoneInt || strlen($phoneInt) != 11) {
            $this->addError($model, $attribute, 'Телефон должен быть в полном формате - содержать 11 цифр!');
        }
    }
}