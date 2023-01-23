<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
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
    protected $baseUrl = 'https://api.taqnyat.sa';


    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * Send message
     * @param string $message
     * @param array|string  $recipients
     * @param string $sender
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string $sender, array|string $recipients): SmsDriverResponse
    {
        $request = [
            'recipients' => is_array($recipients) ? $recipients : [$recipients],
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
