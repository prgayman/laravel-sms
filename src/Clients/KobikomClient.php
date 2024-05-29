<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Prgayman\Sms\SmsDriverResponse;

class KobikomClient
{
    /**
     * Api Key
     * @var string
     */
    protected string $apiKey;

    /**
     * Api Base Url
     * @var string
     */
    protected string $baseUrl = 'https://smspaneli.kobikom.com.tr/sms/api';

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
     * @return SmsDriverResponse
     */
    private function sendSingle(string $message, string $sender, string $mobile): SmsDriverResponse
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
     * @param string $message
     * @param string $sender
     * @param array $mobiles
     * @return SmsDriverResponse
     * @throws ConnectionException
     */
    private function sendMultiple(string $message, string $sender, array $mobiles): SmsDriverResponse
    {
        $request = [
            "body" => array_map(fn($mobile) => [
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
     * @param string $message
     * @param string|array $sender
     * @param array|string $mobile
     * @return SmsDriverResponse
     */
    public function send(string $message, string|array $sender, array|string $mobile): SmsDriverResponse
    {
        return $this->{is_array($mobile) ? "sendMultiple" : "sendSingle"}($message, $sender, $mobile);
    }
}
