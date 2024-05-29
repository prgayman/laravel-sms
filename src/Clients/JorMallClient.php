<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Prgayman\Sms\SmsDriverResponse;

class JorMallClient
{
    /**
     * Acc Name
     *
     * @var string
     */
    protected string $accName;

    /**
     * Password
     *
     * @var string
     */
    protected string $password;

    /**
     * Api Base Url
     *
     * @var string
     */
    protected string $baseUrl = 'https://josmsservice.com/SMSServices/Clients/Prof';

    public function __construct(string $accName, string $password)
    {
        $this->accName = $accName;
        $this->password = $password;
    }

    /**
     * Send single sms
     *
     * @param string $sender
     * @param string $message
     * @param string $mobile
     * @return SmsDriverResponse
     * @throws ConnectionException
     */
    private function sendSingle(string $message, string $sender, string $mobile): SmsDriverResponse
    {
        $request = [
            "numbers" => str_replace('+', '', $mobile),
            "senderid" => $sender,
            "AccName" => $this->accName,
            "AccPass" => $this->password,
            "msg" => $message,
            'id' => ''
        ];

        $response = Http::asForm()->post("$this->baseUrl/SingleSMS/SMSService.asmx/SendSMS", $request);

        return new SmsDriverResponse(
            $request,
            $response->body(),
            $response->successful() && Str::is("*\r\n*MsgID = *", $response->body()),
            $response->body()
        );
    }

    /**
     * Send single sms
     *
     * @param string $sender
     * @param string $message
     * @param array|string $mobile
     * @return SmsDriverResponse
     * @throws ConnectionException
     */
    public function send(string $message, string $sender, mixed $mobile): SmsDriverResponse
    {
        return $this->sendSingle($message, $sender, $mobile);
    }
}
