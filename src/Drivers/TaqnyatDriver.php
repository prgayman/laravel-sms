<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\TaqnyatClient;
use Prgayman\Sms\Contracts\DriverMultipleContactsInterface;
use Prgayman\Sms\SmsDriverResponse;

class TaqnyatDriver extends Driver implements DriverMultipleContactsInterface
{
    /**
     * Authorization bearer token
     * @var string
     */
    protected $authorization;


    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $authorization, ?string $senderName = null)
    {
        $this->authorization = $authorization;
        $this->senderName = $senderName;
    }

    public function client()
    {
        return new TaqnyatClient($this->authorization);
    }

    public function send(): SmsDriverResponse
    {
        return $this->client()->send($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
