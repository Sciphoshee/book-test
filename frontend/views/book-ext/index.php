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
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function(\common\models\Book $book){
                return Html::a($book->name, ['book/view', 'id' => $book->id]);
            }
        ],
        'isbn',
        'release_year',
        'description',
    ],
]);

$this->title = 'Список книг';

?>

<div class="book-edit">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
    ?>
    <a class="btn btn-sm btn-success" href="<?= Url::to(['book/add']); ?>">Добавить книгу</a>
    <?php } ?>

    <?= $grid; ?>
</div>
