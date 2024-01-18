<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Prgayman\Sms\SmsDriverResponse;

class MsegatClient {
    /**
     * Account Username
     * 
     * @var string
     */
    protected $username;

    /**
     * Api Key
     * 
     * @var string
     */
    protected $apiKey;

    /**
     * Api Base Url
     * 
     * @var string
     */
    protected $baseUrl = 'https://www.msegat.com';

    public function __construct(string $username, string $apiKey) {
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    /**
     * Send message 
     * @param string $message
     * @param array|string  $recipients
     * @param string $sender
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string $sender, $numbers): SmsDriverResponse {
        $request = [
            "userName"      => $this->username,
            "apiKey"       => $this->apiKey,
            "numbers"      => is_array($numbers)
                ? implode(",", array_map(function ($to) {
                    return str_replace('+', '', $to);
                }, $numbers))
                : str_replace('+', '', $numbers),
            "userSender"   => $sender,
            "msg"          => $message
        ];

        $response = Http::post("{$this->baseUrl}/gw/sendsms.php", $request);

        return new SmsDriverResponse(
            $request,
            $response->json(),
            $this->successful($response->json("code")),
            "{$response->json('code')} | {$response->json('message')}"
        );
    }

    /**
     * Determine if successful send message
     * 
     * @param string|null
     * @return true
     */
    private function successful(?string $code = null): bool {
        return !is_null($code) && in_array($code, ["1", "M0000", 1]);
    }
}
