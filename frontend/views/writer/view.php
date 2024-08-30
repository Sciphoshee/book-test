<?php

/**
 * @var \yii\web\View $this;
 * @var Writer $model
 * @var \yii\data\DataProviderInterface $booksDataProvider
 * @var \common\models\form\WriterSubscribe\WriterSubscribeFormInterface $subscribeForm
 *
 */


use common\models\Book;
use common\models\Writer;
use yii\helpers\Html;

$details = \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'lastname',
        'firstname',
        'patronymic',
    ]
]);

$gridBooks = \yii\grid\GridView::widget([
    'dataProvider' => $booksDataProvider,
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
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function (Book $model) {
                return $model->getStatusName();
            }
        ],
    ],
]);

$this->title = "Писатель";

?>

<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $details ?>

    <div class="row">
        <div class="col-8">

            <h2>Книги</h2>

            <?= $gridBooks; ?>

        </div>
        <div class="col-4">

            <h4>Подписка на новые книги автора</h4>

            <?php
            $viewFile = !$subscribeForm->isSubscribed() ? '_subscribe_form' : '_subscribed';

            echo $this->render($viewFile, [
                'subscribeForm' => $subscribeForm,
            ]);
            ?>

        </div>
    </div>

</div>
