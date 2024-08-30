<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var \common\models\Writer $modelWriter
 * @var \common\models\Writer[] $writers
 *
 */

use yii\bootstrap5\Html;

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['book/index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['book/view', 'id' => $model->id]];

?>

<div class="book-edit">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_ext', [
        'model' => $model,
        'modelWriter' => $modelWriter,
        'writers' => $writers,
    ]); ?>
</div>