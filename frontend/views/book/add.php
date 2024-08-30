<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var \common\models\Writer $modelWriter
 *
 */

use yii\bootstrap5\Html;

$this->title = 'Добавление книги';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="book-add">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>