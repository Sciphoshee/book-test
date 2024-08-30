<?php

namespace common\components\WriterSubscribeNotifier;

class PhoneWriterSubscribeNotifier implements WriterSubscribeNotifierInterface
{
    public function notify(string $sendTo, string $message): void
    {
        $emulate = false;

        if ($emulate) {
            $infoMessage = sprintf("Отправлено SMS сообщение на номер '%s': %s", $sendTo, $message);
            \Yii::$app->session->addFlash("success", $infoMessage);
        } else {
            $smsSender = \Yii::$app->smsProvider;
            $smsSender->sendSms($sendTo, $message);
        }
    }
}