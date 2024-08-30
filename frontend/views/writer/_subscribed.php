<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/**
 * @var \common\models\form\WriterSubscribe\WriterSubscribeFormInterface $subscribeForm
 */

$form = ActiveForm::begin([
    'id' => 'writer-unsubscribe-form',
]);
?>

    <div>
        <?= $subscribeForm->renderUnsubscribe(); ?>

        <?= Html::activeHiddenInput($subscribeForm, "actionType"); ?>

        <div class="form-group">
            <?= Html::submitButton('Отписаться', ['class' => 'btn btn-sm btn-danger', 'name' => 'writer-unsubscribe-button']) ?>
        </div>
    </div>

<?php
ActiveForm::end()
?>