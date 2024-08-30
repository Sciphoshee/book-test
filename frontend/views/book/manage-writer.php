<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var Writer $writer
 * @var \yii\data\DataProviderInterface $bookWritersDataProvider
 * @var \yii\data\DataProviderInterface $writersDataProvider
 *
 */

use common\models\Writer;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\grid\GridView;

$this->title = $model->name . ' - управление авторами книги';
$this->params['breadcrumbs'][] = $this->title;



$bookWritersGrid = GridView::widget([
    'dataProvider' => $bookWritersDataProvider,
    'columns' => [
        [
            'format' => 'raw',
            'value' => function(Writer $writer) use ($model) {
                return Html::submitButton('X', ['class' => 'btn btn-danger', 'name' => 'remove_writer', 'value' => $writer->id]);
            }
        ],
        'lastname',
        'firstname',
        'patronymic'
    ],
]);

$bookWritersIds = \yii\helpers\ArrayHelper::getColumn($model->writers, 'id');

$writersGrid = GridView::widget([
    'dataProvider' => $writersDataProvider,
    'columns' => [
        [
            'format' => 'raw',
            'value' => function(Writer $writer) use ($model, $bookWritersIds) {
                if (in_array($writer->id, $bookWritersIds)) {
                    $btnText = 'Удалить';
                    $btnClass = 'btn-danger';
                    $btnName = 'remove_writer';
                } else {
                    $btnText = 'Добавить';
                    $btnClass = 'btn-success';
                    $btnName = 'add_writer';
                }
                return Html::submitButton($btnText, ['class' => "btn btn-sm {$btnClass}", 'name' => $btnName, 'value' => $writer->id]);
            }
        ],
        'lastname',
        'firstname',
        'patronymic'
    ],
]);

?>

<div class="book-writer-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'book-writers-form',
    ]); ?>

    <h2>Авторы книги</h2>
    <?= $bookWritersGrid; ?>

    <?php ActiveForm::end(); ?>

    <hr>

    <div style="text-align: center;">
        <?= Html::a('Закончить редактирование, вернуться к книге', ['book/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning']) ?>
    </div>

    <hr>

    <div id="writers">

        <div class="row writer-row">
            <div class="col-md-6">
                <h2>Новый автор</h2>

                <?php $form = ActiveForm::begin([
                    'id' => 'book-writers-form',
                ]); ?>

                <?= $form->field($writer, "lastname")->textInput() ?>
                <?= $form->field($writer, "firstname")->textInput() ?>
                <?= $form->field($writer, "patronymic")->textInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-sm btn-success', 'name' => 'add-writer']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="col-md-6">
                <h2>Все писатели</h2>

                <?php $form = ActiveForm::begin([
                    'id' => 'book-writers-form',
                ]); ?>

                <?= $writersGrid; ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

</div>