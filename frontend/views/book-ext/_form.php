<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var \common\models\Writer $modelWriter
 *
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerJs(<<<JS
    

    
JS
);

?>

<?php $form = ActiveForm::begin([
    'id' => 'book-form',
    'options' => ['enctype' => 'multipart/form-data']
]); ?>

<div class="row">
    <div class="col-lg-12">

        <h4>Основные данные книги:</h4>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'release_year')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea() ?>

        <hr>

        <div class="form-group">
            <?= Html::submitButton('Сохранить книгу', ['class' => 'btn btn-sm btn-success', 'name' => 'book-add-button']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>