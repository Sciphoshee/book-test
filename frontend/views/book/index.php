<?php

/**
 * @var \yii\web\View $this
 * @var \yii\data\DataProviderInterface $dataProvider
 */

use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;

$grid = \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'image_id',
            'format' => 'raw',
            'value' => function (Book $model) {
                return 'Тут будет фото';
            }
        ],
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function(Book $book){
                return Html::a($book->name, ['book/view', 'id' => $book->id]);
            }
        ],
        'release_year',
        [
            'format' => 'raw',
            'label' => 'Авторы',
            'value' => function(Book $book){
                if ($writers = $book->writers) {
                    $writersNames = array_map(function ($writer){
                        return Html::a($writer->getShortName(), ['writer/view', 'id' => $writer->id]);
                    }, $writers);
                    return implode(', ', $writersNames);
                }
                return '';
            }
        ],
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (Book $model) {
                return $model->getStatusName();
            }
        ],
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
