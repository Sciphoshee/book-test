<?php

namespace common\fabric\WriterSubscribe;

use common\components\WriterSubscribeNotifier\PhoneWriterSubscribeNotifier;
use common\components\WriterSubscribeNotifier\WriterSubscribeNotifierInterface;
use common\models\Book;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\form\WriterSubscribe\PhoneWriterSubscribeForm;
use common\models\Writer;

class PhoneWriterSubscribeFabric implements WriterSubscribeFabricInterface
{

    public function getWriterSubscribeForm(Writer $writer): WriterSubscribeFormInterface
    {
        return new PhoneWriterSubscribeForm($writer);
    }

    public function getWritersSubscribeNotifier(): WriterSubscribeNotifierInterface
    {
        return new PhoneWriterSubscribeNotifier();
    }
}