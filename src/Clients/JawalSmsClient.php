<?php

namespace Prgayman\Sms\Clients;

use Illuminate\Support\Facades\Http;
use Prgayman\Sms\Exceptions\ClientException;
use \Illuminate\Http\Client\Response;

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
    protected $baseUrl = 'http://www.jawalsms.net/';

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
     * 
     * @param string $sender
     * @param string $message
     * @param string $mobile
     * 
     * @throws \Prgayman\Sms\Exceptions\ClientException
     * @return \Illuminate\Http\Client\Response
     */
    public function sendSingleSms(string $message, string $sender, string $mobile)
    {
        $response = Http::post("$this->baseUrl/httpSmsProvider.aspx", [
            "username" => $this->username,
            "password" => $this->password,
            "unicode"  => $this->unicode,
            "sender"   => $sender,
            "message"  => $message,
            'mobile'   => str_replace('+', '', $mobile),
        ]);

        $this->successful($response);

        return $response;
    }

    /**
     * Get error message
     * 
     * @throws \Prgayman\Sms\Exceptions\ClientException
     * @return bool
     */
    private function successful(Response $response): bool
    {
        if ($response->successful()) {
            switch ((int) str_replace(" ", "", $response->body())) {
                case "0":
                    return true;
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
                default:
                    $message = "Error Unknown";
                    break;
            }
        } else {
            $message = "Error Unknown";
        }

        throw new ClientException($message);
    }
}
