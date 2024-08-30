<?php

namespace common\interface;

interface SendSmsInterface
{
    public function sendSms($sendTo, $message);
}