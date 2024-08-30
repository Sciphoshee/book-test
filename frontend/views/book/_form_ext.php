<?php

/**
 * @var \yii\web\View $this
 * @var \common\models\Book $model
 * @var \common\models\Writer $modelWriter
 * @var \common\models\Writer[] $writers
 *
 */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerJs(<<<JS
    
    $('#add-writer').on('click', function() {
        let newWriters = $('#new_writers');
        
        let newWriterFormName = newWriters.data('model');
        let modelIndex = newWriters.data('index');
        let modelIndexNew = modelIndex - 1;
        newWriters.data('index', modelIndexNew);
        
        console.log(modelIndex);
        console.log(modelIndexNew);
        console.log(newWriters.data('index'));
        
        let writerRow = $('.writer-row:last').clone();
      
        
        writerRow.find(':input').each(function() {
            let formAttr = $(this).data('attr');
            if ( formAttr != 'id' ) {
                $(this).val('');
            } else {
                $(this).val(modelIndexNew);
            }
            
            let formFieldName = newWriterFormName + '[' + modelIndexNew + '][' + formAttr + ']';
            let formFieldId = newWriterFormName.toLowerCase() + '-' + modelIndexNew + '-' + formAttr;
            
            $(this).attr('name', formFieldName);
            $(this).attr('id', formFieldId);
        });
        
        newWriters.append(writerRow);
    });

    $('.remove-writer').on('click', function() {
        var writerId = $(this).data('writer-id');
        if (writerId) {
            $('#writer_' + writerId).remove();
        }
    })
    
JS
);

$this->registerCss(<<<CSS

.outer {
    display: flex;
    width: 100%;
    height: 100%;
}

.inner {
    width: 50%;
    margin: auto;
}

CSS
);

$modelIndexNew = -1;

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

        <h4>Автор(-ы) книги:</h4>

        <?php

        if (!empty($writers)) {
            /** @var \common\models\Writer $writer */
            foreach ($writers as $writer) {
                ?>
                <div id="writers">

                    <div class="row writer-row" id="writer_<?= $writer->id; ?>">
                        <div class="col-md-1">
                            <div class="outer">
                                <?= Html::button('X', ['class' => 'btn btn-sm btn-danger inner remove-writer', 'data-writer-id' => $writer->id]) ?>
                            </div>
                        </div>

                        <?= Html::activeHiddenInput($writer, "[{$writer->id}]id") ?>

                        <div class="col">
                            <?= $form->field($writer, "[{$writer->id}]lastname")->textInput(['readonly' => true]) ?>
                        </div>
                        <div class="col">
                            <?= $form->field($writer, "[{$writer->id}]firstname")->textInput(['readonly' => true]) ?>
                        </div>
                        <div class="col">
                            <?= $form->field($writer, "[{$writer->id}]patronymic")->textInput(['readonly' => true]) ?>
                        </div>
                    </div>

                </div>
                <?php
            }
        }

        ?>

        <h4>Добавить нового автора:</h4>

        <div id="new_writers" data-model="<?= $modelWriter->formName(); ?>" data-index="<?= $modelIndexNew;?>">

            <div class="row writer-row">
                <div class="col">
                    <?= Html::hiddenInput("{$modelWriter->formName()}[{$modelIndexNew}][id]", $modelIndexNew, ['class' => 'field-id', 'data-attr' => 'id']) ?>

                    <?= $form->field($modelWriter, "[{$modelIndexNew}]lastname")->textInput(['maxlength' => true, 'data-attr' => 'lastname']) ?>
                </div>
                <div class="col">
                    <?= $form->field($modelWriter, "[{$modelIndexNew}]firstname")->textInput(['maxlength' => true, 'data-attr' => 'firstname']) ?>
                </div>
                <div class="col">
                    <?= $form->field($modelWriter, "[{$modelIndexNew}]patronymic")->textInput(['maxlength' => true, 'data-attr' => 'patronymic']) ?>
                </div>
            </div>

        </div>


        <div class="form-group">
            <?= Html::button('Добавить поле для автора', ['class' => 'btn btn-sm btn-primary', 'id' => 'add-writer']) ?>
        </div>

        <hr>

        <div class="form-group">
            <?= Html::submitButton('Сохранить книгу', ['class' => 'btn btn-sm btn-success', 'name' => 'book-add-button']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>