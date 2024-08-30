<?php

namespace common\fabric\WriterSubscribe;

use common\components\WriterSubscribeNotifier\WriterSubscribeNotifierInterface;
use common\models\Book;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\Writer;

interface WriterSubscribeFabricInterface
{
    public function getWriterSubscribeForm(Writer $writer): WriterSubscribeFormInterface;

    public function getWritersSubscribeNotifier(): WriterSubscribeNotifierInterface;
}