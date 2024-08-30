<?php

namespace common\models\search;

use common\models\form\WritersTopForYearFrom;
use common\models\Writer;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\DataProviderInterface;
use yii\db\Expression;

class WritersTopSearch extends WritersTopForYearFrom
{
    public function search(array $params): DataProviderInterface
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => [],
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query = WritersTopForYearFrom::find()
            ->select([
                WritersTopForYearFrom::tableName() . '.*',
                new Expression("COUNT(*) AS books_count")
            ])
            ->innerJoinWith(['books' => function ($query) {
                return $query->andWhere(['release_year' => $this->release_year]);
            }])
            ->groupBy([Writer::tableName() . '.id'])
            ->orderBy(['books_count' => SORT_DESC]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}