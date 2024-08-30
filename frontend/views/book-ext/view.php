<?php

/**
 * @var \yii\web\View $this;
 * @var Book $model
 *
 *
 */


use common\models\Book;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

$details = \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'name',
        'release_year',
        'isbn',
        'description:ntext',
        [
            'attribute' => 'writers',
            'format' => 'raw',
            'value' => function(Book $book){
                $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $book->writers,
                ]);

                return \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'lastname:ntext:Фамилия',
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
        <div class="col-md-12">
            <a class="btn btn-sm btn-secondary" href="<?= Url::to(['book/edit', 'id' => $model->id]); ?>">Редактировать</a>
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
