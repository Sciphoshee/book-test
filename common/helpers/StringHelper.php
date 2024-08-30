<?php

namespace common\helpers;

class StringHelper extends \yii\helpers\StringHelper
{
    /**
     * Получить из переменной только цифры
     *
     * @param $var
     * @return int|null
     */
    public static function onlyInt($var): ?int
    {
        $int = preg_replace("/[^0-9]/", "", $var);

        return is_numeric($int) ? $int : null;
    }
}