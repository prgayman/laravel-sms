<?php

namespace Prgayman\Sms\Drivers;

use Exception;
use Prgayman\Sms\SmsDriverResponse;
use Twilio\Rest\Client;

class TwilioDriver extends Driver
{
    /**
     * Twilio Sid
     * @var string
     */
    protected $sid;

    /**
     * Twilio Token
     * @var string
     */
    protected $token;

    /**
     * Twilio default options
     * @var array
     */
    protected $defaultOptions;

    /**
     * Create a new log transport instance.
     * @return void
     */
    public function __construct(string $sid, string $token, ?string $senderName = null, array $defaultOptions = [])
    {
        $this->sid = $sid;
        $this->token = $token;
        $this->senderName = $senderName;
        $this->defaultOptions = $defaultOptions;
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
            'options' => [
                ...$this->defaultOptions,
                $this->getOptions()
            ],
        ];
        try {
            $response =  $this->client()
                ->messages
                ->create(
                    $request['to'],
                    [
                        'from' => $request['from'],
                        'body' => $request['body'],
                        ...$request['options']
                    ]
                );
            return new SmsDriverResponse($request, $response, true);
        } catch (Exception $e) {
            return new SmsDriverResponse($request, null, false, $e->getMessage());
        }
    }
}
