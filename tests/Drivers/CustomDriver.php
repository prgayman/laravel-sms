<?php

namespace Prgayman\Sms\Test\Drivers;

use Prgayman\Sms\Drivers\Driver;
use Prgayman\Sms\SmsDriverResponse;

class CustomDriver extends Driver
{
    public function send(): SmsDriverResponse
    {
        $request = [
            "type" => $this->getType(),
            "to"   => $this->getTo(),
            'from' => $this->getFrom(),
            'body' => $this->getMessage(),
        ];

        try {
            # Handler send message
            $response = null;
            return new SmsDriverResponse($request, $response, true);
        } catch (\Exception $e) {
            return new SmsDriverResponse($request, null, false, $e->getMessage());
        }
    }
}
