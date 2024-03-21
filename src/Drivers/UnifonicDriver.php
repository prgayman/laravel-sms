<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\UnifonicClient;
use Prgayman\Sms\SmsDriverResponse;

class UnifonicDriver extends Driver
{
    /**
     * Unifonic Sid
     *
     * @var string
     */
    protected string $sid;

    /**
     * Unifonic message type
     *
     * @var int
     */
    protected int $messageType;

    /**
     * Create a new log transport instance.
     * @return void
     */
    public function __construct(string $sid, ?string $senderName = null, int $messageType = 3)
    {
        $this->sid = $sid;
        $this->senderName = $senderName;
        $this->messageType = $messageType;
    }

    public function client()
    {
        return new UnifonicClient($this->sid, $this->messageType);
    }

    public function send(): SmsDriverResponse
    {
        return $this->client()->send($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
