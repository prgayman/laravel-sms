<?php

namespace Prgayman\Sms\Clients;

use Prgayman\Sms\SmsDriverResponse;

class UnifonicClient
{
    /**
     * Application SID
     *
     * @var string
     */
    protected string $appSid;

    /**
     * Message Type
     *
     * @var int
     */
    protected int $messageType;

    /**
     * Api Base Url
     *
     * @var string
     */
    protected string $baseUrl = 'https://el.cloud.unifonic.com';

    public function __construct(string $appSid, int $messageType = 3)
    {
        $this->appSid = $appSid;
        $this->messageType = $messageType;
    }

    /**
     * Send message
     *
     * @param string $message
     * @param string $recipient
     * @param string $sender
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(string $message, string $sender, string $recipient): SmsDriverResponse
    {
        $request = [
            'AppSid' => $this->appSid,
            'SenderID' => $sender,
            'Body' => $message,
            'Recipient' => str_replace('+', "00", $recipient),
            'baseEncode' => false,
            "MessageType" => $this->messageType,
            "statusCallback" => "sent"
        ];

        $response = \Http::withHeaders(['Accept' => 'application/json'])
            ->post("{$this->baseUrl}/rest/SMS/messages", $request);

        return new SmsDriverResponse(
            $request,
            $response->json(),
            $response->successful()
            && $response->json('success') == true
            && $response->json('errorCode') == "ER-00",
            $response->json('message')
        );
    }
}
