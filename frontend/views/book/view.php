<?php

/**
 * @var \yii\web\View $this;
 * @var Book $model
 *
 *
 */


use common\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;

$details = \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (Book $model) {
                $publishBtn = '';
                if (!Yii::$app->user->isGuest && $model->status === Book::STATUS_DRAFT) {
                    $publishBtn = Html::a('Опубликовать', ['book/publish', 'id' => $model->id], ['class' => 'btn btn-sm btn-success']);
                }

                return $model->getStatusName() . ($publishBtn ? ' ' . $publishBtn : '');
            }
        ],
        'name',
        'release_year',
        'isbn',
        'description:ntext',
        [
            'attribute' => 'writers',
            'format' => 'raw',
            'value' => function(Book $book){
                $dataProvider = new \yii\data\ActiveDataProvider([
                    'query' => $book->getWriters(),
                ]);

                return \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'lastname',
                            'format' => 'raw',
                            'value' => function(\common\models\Writer $writer){
                                return Html::a($writer->lastname, ['writer/view', 'id' => $writer->id]);
                            }
                        ],
                        'firstname:ntext:Имя',
                        'patronymic:ntext:Отчество',
                    ]
                ]);
            }
        ]
    ]
]);

$this->title = "Книга '{$model->name}' ({$model->release_year})";

?>

<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (!Yii::$app->user->isGuest) {
    ?>
    <div class="row mb-3">
        <div class="col-md-8">
            <?= Html::a('Редактировать', ['book/edit', 'id' => $model->id], ['class' => 'btn btn-sm btn-info']) ?>
            <?= Html::a('Управление авторами книги', ['book/manage-writer', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
        <div class="col-md-4" style="text-align: right;">
            <?= Html::a('Удалить книгу', ['book/delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger']) ?>
        </div>
    </div>

    <?php
    }
    ?>

    <div class="row">
        <div class="col-md-12">

            <?= $details ?>

        </div>
    </div>
</div>
