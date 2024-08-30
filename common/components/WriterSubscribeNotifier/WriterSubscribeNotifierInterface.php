<?php

namespace common\components\WriterSubscribeNotifier;

use common\models\Writer;

interface WriterSubscribeNotifierInterface
{
    public function notify(string $sendTo, string $message): void;
}