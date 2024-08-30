<?php

namespace common\fabric\WriterSubscribe;

use common\components\WriterSubscribeNotifier\EmailWriterSubscribeNotifier;
use common\components\WriterSubscribeNotifier\WriterSubscribeNotifierInterface;
use common\models\form\WriterSubscribe\EmailWriterSubscribeForm;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\Writer;

class EmailWriterSubscribeFabric implements WriterSubscribeFabricInterface
{

    public function getWriterSubscribeForm(Writer $writer): WriterSubscribeFormInterface
    {
        return new EmailWriterSubscribeForm($writer);
    }

    public function getWritersSubscribeNotifier(Writer $writer): WriterSubscribeNotifierInterface
    {
        return new EmailWriterSubscribeNotifier($writer);
    }
}