<?php

/**
 * @var \yii\web\View $this
 * @var WritersTopSearch $model
 * @var \yii\data\DataProviderInterface $dataProvider
 */

use common\models\search\WritersTopSearch;
use yii\helpers\Html;
use yii\helpers\Url;

$grid = \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'books_count',
        [
            'attribute' => 'lastname',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::a($model->lastname, ['writer/view', 'id' => $model->id]);
            }
        ],
        'firstname',
        'patronymic'
    ],
]);

$this->title = 'Статистика';

?>

<div class="writers-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', [
        'model' => $model,
    ]) ?>

    <?= $grid; ?>
</div>
