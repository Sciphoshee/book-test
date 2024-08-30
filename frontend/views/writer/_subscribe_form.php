<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

/**
 * @var \common\models\form\WriterSubscribe\WriterSubscribeFormInterface $subscribeForm
 */

$form = ActiveForm::begin([
    'id' => 'writer-subscribe-form',
]);

\yii\bootstrap5\Alert::widget();

?>

<div>
    <?= $subscribeForm->renderSubscribeActiveFormField($form); ?>

    <?= Html::activeHiddenInput($subscribeForm, "actionType"); ?>

    <div class="form-group">
        <?= Html::submitButton('Подписаться', ['class' => 'btn btn-sm btn-success', 'name' => 'writer-subscribe-button']) ?>
    </div>
</div>

<?php
ActiveForm::end()
?>