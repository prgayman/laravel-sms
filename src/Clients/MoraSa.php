<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Prgayman\Sms\SmsDriverResponse;

class MoraSa
{
    /**
     * Username
     * @var string
     */
    protected $username;

    /**
     * Api Key
     * @var string
     */
    protected $apiKey;

    /**
     * Api Base Url
     * @var string
     */
    protected $baseUrl = 'http://mora-sa.com/api/v1';

    public function __construct(string $username, string $apiKey)
    {
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    /**
     * Send single sms
     * @param string $sender
     * @param string $message
     * @param array|string $mobile
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string $sender, $mobile): SmsDriverResponse
    {
        $mobile = is_array($mobile)
            ? implode(",", array_map(function ($to) {
                return str_replace('+', '', $to);
            }, $mobile))
            : str_replace('+', '', $mobile);

        $request = [
            "username" => $this->username,
            "api_key" => $this->apiKey,
            "message" => $message,
            "sender" => $sender,
            "numbers" => $mobile
        ];

        $response = Http::get("$this->baseUrl/sendsms", $request);

        return new SmsDriverResponse(
            $request,
            $response->body(),
            $response->successful() && $response->json("data.code") == 100,
            $response->json("data.message", $response->json('status.message'))
        );
    }
}
