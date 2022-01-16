<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Prgayman\Sms\Exceptions\ClientException;
use \Illuminate\Http\Client\Response;

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
     * @throws \Prgayman\Sms\Exceptions\ClientException
     * @return \Illuminate\Http\Client\Response
     */
    public function sendSingleSms(string $message, string $sender, string $mobile): Response
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
     * @throws \Prgayman\Sms\Exceptions\ClientException
     * @return \Illuminate\Http\Client\Response
     */
    private function send(string $message, array $recipients, string $sender): Response
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->authorization}",
        ])
            ->post("{$this->baseUrl}/v1/messages", [
                'recipients' => $recipients,
                'sender' => $sender,
                'body' => $message,
            ]);

        if ($response->failed()) {
            throw new ClientException("{$response->json('message', 'Send failed')}, status code is [{$response->status()}]");
        }

        return $response;
    }
}
