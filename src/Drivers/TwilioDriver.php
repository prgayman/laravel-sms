<?php

namespace Prgayman\Sms\Drivers;

use Exception;
use Prgayman\Sms\SmsDriverResponse;
use Twilio\Rest\Client;

class TwilioDriver extends Driver
{

    /**
     * Twilio Sid
     * 
     * @var string
     */
    protected $sid;

    /**
     * Twilio Token
     * 
     * @var string
     */
    protected $token;

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $sid, string $token, ?string $senderName = null)
    {
        $this->sid = $sid;
        $this->token = $token;
        $this->senderName = $senderName;
    }

    public function client()
    {
        return new Client($this->sid, $this->token);
    }

    public function send(): SmsDriverResponse
    {
        $request = [
            "to" => $this->getTo(),
            'from' => $this->getFrom(),
            'body' => $this->getMessage(),
        ];
        try {
            $response =  $this->client()
                ->messages
                ->create(
                    $request['to'],
                    [
                        'from' => $request['from'],
                        'body' => $request['body']
                    ]
                );
            return new SmsDriverResponse($request, $response, true);
        } catch (Exception $e) {
            return new SmsDriverResponse($request, null, false, $e->getMessage());
        }
    }
}
