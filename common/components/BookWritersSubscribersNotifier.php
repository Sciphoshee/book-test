<?php

namespace common\components;

use common\fabric\WriterSubscribe\WriterSubscribeFabricInterface;
use common\models\Book;
use common\models\form\WriterSubscribe\WriterSubscribeFormInterface;
use common\models\Writer;
use Yii;
use yii\base\Component;

class BookWritersSubscribersNotifier extends Component
{
    private $book;
    private $writerSubscribeNotifier;
    private $subscriberContactFieldName;

    public function init()
    {
        $fabric = Yii::createObject(WriterSubscribeFabricInterface::class);
        $this->writerSubscribeNotifier = $fabric->getWritersSubscribeNotifier();

        parent::init();
    }

    public function notify(Book $book): void
    {
        $this->book = $book;

        if ($this->book->writers) {
            foreach ($this->book->writers as $writer) {
                $writerSubscribers = $this->getWriterSubscribers($writer);

                //TODO Очень плохой вариант ((
                $this->getSubscriberContactFieldName($writer);
                if (!$this->subscriberContactFieldName) {
                    throw new \LogicException('Subscriber contact field name is not set');
                }

                if ($writerSubscribers) {
                    $message = $this->getMessage($writer);

                    foreach ($writerSubscribers as $subscriber) {
                        $sendTo = $subscriber->{$this->subscriberContactFieldName};

                        if ($sendTo) {
                            $this->writerSubscribeNotifier->notify($sendTo, $message);
                        }
                    }
                }

            }
        }
    }

    private function getWriterSubscribers(Writer $writer)
    {
        return $writer->subscribers;
    }

    private function getMessage(Writer $writer): string
    {
        return sprintf("Вышла новая книга '%s' писателя %s", $this->book->name, $writer->getShortName());
    }

    private function getSubscriberContactFieldName(Writer $writer): string
    {
        if ($this->subscriberContactFieldName) {
            return $this->subscriberContactFieldName;
        }

        $fabric = Yii::createObject(WriterSubscribeFabricInterface::class);
        /** @var WriterSubscribeFormInterface $form */
        $form = $fabric->getWriterSubscribeForm($writer);
        $this->subscriberContactFieldName = $form->getContactFieldName();

        return $this->subscriberContactFieldName;
    }
}