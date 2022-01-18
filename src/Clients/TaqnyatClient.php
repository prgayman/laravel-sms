<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use \Illuminate\Http\Client\Response;
use Prgayman\Sms\SmsDriverResponse;

class TaqnyatClient
{
    /**
     * Authorization bearer token
     * @var string
     */
    protected $authorization;

    /**
     * Api Base Url
     * @var string
     */
    protected $baseUrl = 'https://api.taqnyat.sa/';


    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * Send single sms
     * 
     * @param string $sender
     * @param string $message
     * @param string $mobile
     * 
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function sendSingleSms(string $message, string $sender, string $mobile): SmsDriverResponse
    {
        return $this->send($message, [$mobile], $sender);
    }

    /**
     * Send message
     * 
     * @param string $message
     * @param array $recipients
     * @param string $sender
     * 
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    private function send(string $message, array $recipients, string $sender): SmsDriverResponse
    {
        $request = [
            'recipients' => $recipients,
            'sender' => $sender,
            'body' => $message,
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->authorization}",
        ])
            ->post("{$this->baseUrl}/v1/messages", $request);


        return new SmsDriverResponse(
            $request,
            $response->json(),
            $response->successful(),
            $response->json('message')
        );
    }
}
