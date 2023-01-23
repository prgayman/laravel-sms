<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Prgayman\Sms\SmsDriverResponse;

class JawalSmsClient
{
    /**
     * Username
     * @var string
     */
    protected $username;

    /**
     * Password
     * @var string
     */
    protected $password;

    /**
     * Api Base Url
     * @var string
     */
    protected $baseUrl = 'https://www.jawalsms.net';

    /**
     * Message unicode
     * @var string
     */
    protected $unicode = "E";

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Send single sms
     * @param string $sender
     * @param string $message
     * @param array|string $mobile
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string $sender, array|string $mobile): SmsDriverResponse
    {
        $mobile = is_array($mobile)
            ? implode(",", array_map(function ($to) {
                return str_replace('+', '', $to);
            }, $mobile))
            : str_replace('+', '', $mobile);

        $request = [
            "username" => $this->username,
            "password" => $this->password,
            "unicode"  => $this->unicode,
            "sender"   => $sender,
            "message"  => $message,
            'mobile'   => $mobile,
        ];

        $response = Http::post("$this->baseUrl/httpSmsProvider.aspx", $request);

        $errorMessage = $this->getErrorMessage($response);

        return new SmsDriverResponse(
            $request,
            $response->body(),
            is_null($errorMessage) ? true : false,
            $errorMessage
        );
    }

    private function getErrorMessage(Response $response)
    {
        if ($response->successful()) {
            switch ((int) str_replace(" ", "", $response->body())) {
                case "0":
                    return null;
                case "101":
                    $message = "Parameter are missing";
                    break;
                case "104":
                    $message = "Either user name or password are missing or your Account is on hold";
                    break;
                case "105":
                    $message = "Credit are not available";
                    break;
                case "106":
                    $message = "Wrong Unicode";
                    break;
                case "107":
                    $message = "Blocked aender Name";
                    break;
                case "108":
                    $message = "Missing sender name";
                    break;
                case "1011":
                    $message = "There is a wrong content in the link";
                    break;
                case "11":
                    $message = "You have not a permission to or your account info is incorrect";
                    break;
                default:
                    $message = "Error Unknown";
                    break;
            }
        } else {
            $message = "Error Unknown";
        }

        return $message;
    }
}
