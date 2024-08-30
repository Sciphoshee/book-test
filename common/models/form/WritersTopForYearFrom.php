<?php

namespace common\models\form;

use common\models\Writer;
use yii\helpers\ArrayHelper;

class WritersTopForYearFrom extends Writer
{
    public $release_year;
    public $books_count;

    public function init()
    {
        $this->release_year = date('Y');
        parent::init();
    }

    public function rules()
    {
        return [
            ['books_count', 'integer', 'min' => 0],
            [['release_year'], 'integer', 'max' => date('Y')],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'release_year' => 'Год издания',
            'books_count' => 'Кол-во книг',
        ]);
    }
}