<?php

/**
 * @var \yii\web\View $this
 * @var \yii\data\DataProviderInterface $dataProvider
 */

use yii\helpers\Html;
use yii\helpers\Url;

$grid = \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'lastname',
            'format' => 'raw',
            'value' => function(\common\models\Writer $model){
                return Html::a($model->lastname, ['writer/view', 'id' => $model->id]);
            }
        ],
        'firstname',
        'patronymic',
    ],
]);

$this->title = 'Список писателей';

?>

<div class="writers-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (false && !Yii::$app->user->isGuest) {
        ?>
        <a class="btn btn-sm btn-success" href="<?= Url::to(['writer/add']); ?>">Добавить писателя</a>
    <?php } ?>

    <?= $grid; ?>
</div>
