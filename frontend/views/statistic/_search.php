<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var \common\models\Writer $modelWriter
 *
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'writers-top-form',
]); ?>

    <div class="row" style="padding-bottom: 24px;">
        <div class="col-lg-12">

            <h4>Укажите год издания:</h4>

            <?= $form->field($model, 'release_year')->textInput(['type' => 'number', 'max' => date('Y')]) ?>

            <div class="form-group">
                <?= Html::submitButton('Показать', ['class' => 'btn btn-sm btn-success', 'name' => 'show-stat-button']) ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>