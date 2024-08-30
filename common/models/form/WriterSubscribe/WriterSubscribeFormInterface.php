<?php

namespace common\models\form\WriterSubscribe;

use common\models\Writer;
use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;

interface WriterSubscribeFormInterface
{
    public function __construct(Writer $writer, $config = []);

    public function getContactFieldName(): string;

    public function execute(): bool;

    public function isSubscribed(): bool;

    public function renderSubscribeActiveFormField(ActiveForm $form): ActiveField;

    public function renderUnsubscribe(): string;
}