<?php

namespace common\components;

use common\interface\SendSmsInterface;
use yii\base\Component;

class SmsPilot extends Component implements SendSmsInterface
{
    public $baseUrl;
    public $apiKey;

    public $fromName;

    public $format = 'json';

    public function sendSms($sendTo, $message): bool
    {
        $url = $this->getUrl($sendTo, $message);

        $json = file_get_contents( $url );
//        echo $json.'<br/>';
// {"send":[{"server_id":"10000","phone":"79081234567","price":"1.68","status":"0"}],"balance":"11908.50","cost":"1.68"}
// {"error":{"code": "400", "description": "User not found", "description_ru": "Пользователь не найден" }

        $j = json_decode( $json );
        if ( !isset($j->error)) {
            $infoMessage = sprintf(
                "SMSPilot: Отправлено SMS сообщение на номер '%s': %s (server_id = %s)",
                $sendTo,
                $message,
                $j->send[0]->server_id
            );
            \Yii::$app->session->addFlash("success", $infoMessage);
            return true;
        } else {
            trigger_error( $j->error->description_ru, E_USER_WARNING );
            \Yii::$app->session->addFlash("error", $j->error->description_ru);
            return false;
        }
    }

    private function getUrl($sendTo, $message): string
    {
        return sprintf(
            "%s?send=%s&to=%s&from=%s&apikey=%s&format=%s",
            $this->baseUrl,
            urlencode( $message ),
            urlencode( $sendTo ),
            $this->fromName,
            $this->apiKey,
            $this->format
        );
    }
}