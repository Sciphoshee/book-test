<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Book list';
?>
<div class="site-index">
    <div class="mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1>Сайт про книги и их авторов</h1>

            <?php
            if (!Yii::$app->user->isGuest) {
            ?>
            <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/book/add']); ?>">Добавить книгу</a></p>
            <?php } ?>

        </div>
    </div>
</div>
