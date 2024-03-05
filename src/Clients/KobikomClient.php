<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Prgayman\Sms\SmsDriverResponse;

class KobikomClient
{
    /**
     * Api Key
     * @var string
     */
    protected $apiKey;

    /**
     * Api Base Url
     * @var string
     */
    protected $baseUrl = 'https://smspaneli.kobikom.com.tr/sms/api';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Send single sms
     * 
     * @param string $sender
     * @param string $message
     * @param string $mobile
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    private function snedSingle(string $message, string $sender, string $mobile): SmsDriverResponse
    {
        $request = [
            "action" => "send-sms",
            "api_key" => $this->apiKey,
            "to" => str_replace('+', '', $mobile),
            "from" => $sender,
            "sms" => $message,
            "unicode" => 1
        ];

        $response = Http::get($this->baseUrl, $request);

        return new SmsDriverResponse(
            $request,
            $response->body(),
            $response->successful() && $response->json("code") == "ok",
            $response->json("message")
        );
    }

    /**
     * Send Multiple sms
     * 
     * @param string $sender
     * @param string $message
     * @param array $mobile
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    private function snedMultiple(string $message, string $sender, array $mobiles): SmsDriverResponse
    {
        $request = [
            "body" => array_map(fn ($mobile) => [
                "from" => $sender,
                "to" => str_replace('+', '', $mobile),
                "sms" => $message,
                "unicode" => 1
            ], $mobiles),
            "action" => "send-sms",
            "api_key" => $this->apiKey
        ];
        $response = Http::withBody(json_encode($request["body"]))
            ->post("{$this->baseUrl}/multiple?action={$request['action']}&api_key={$request['api_key']}");

        return new SmsDriverResponse(
            $request,
            $response->body(),
            $response->successful() && $response->json("success") == 2,
        );
    }

    /**
     * Send single and multiple sms
     * @param string $sender
     * @param string $message
     * @param array|string $mobile
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string|array $sender, $mobile): SmsDriverResponse
    {
        return $this->{is_array($mobile) ? "snedMultiple" : "snedSingle"}($message, $sender, $mobile);
    }
}
