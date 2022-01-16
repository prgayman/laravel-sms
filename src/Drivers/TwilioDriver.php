<?php

namespace Prgayman\Sms\Drivers;

use Twilio\Rest\Client;

class TwilioDriver extends Driver
{

    /**
     * Twilio Sid
     * 
     * @var string
     */
    protected $sid;

    /**
     * Twilio Token
     * 
     * @var string
     */
    protected $token;

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $sid, string $token, ?string $senderName = null)
    {
        $this->sid = $sid;
        $this->token = $token;
        $this->senderName = $senderName;
    }

    public function client()
    {
        return new Client($this->sid, $this->token);
    }

    public function send()
    {
        return  $this->client()
            ->messages
            ->create(
                $this->getTo(),
                [
                    'from' => $this->getFrom(),
                    'body' => $this->getMessage(),
                ]
            );
    }
}
