<?php

namespace common\components\WriterSubscribeNotifier;

use Yii;

class EmailWriterSubscribeNotifier implements WriterSubscribeNotifierInterface
{
    public function notify($sendTo, $message): void
    {
        $mailer = \Yii::$app->mailer;

        $infoMessage = sprintf("Отправлено Email сообщение на адрес '%s': %s", $sendTo, $message);
        \Yii::$app->session->addFlash('success', $infoMessage);
    }

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}