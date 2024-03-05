<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\KobikomClient;
use Prgayman\Sms\Contracts\DriverMultipleContactsInterface;
use Prgayman\Sms\SmsDriverResponse;

class KobikomDriver extends Driver implements DriverMultipleContactsInterface
{
    /**
     * Api Key
     * 
     * @var string
     */
    protected $apiKey;

    /**
     * Sender name
     * 
     * @var string
     */
    protected $senderName;

    /**
     * Create a new log transport instance.
     *
     * @param string $apiKey
     * @param string|null $senderName
     * @return void
     */
    public function __construct(string $apiKey, ?string $senderName = null)
    {
        $this->apiKey = $apiKey;
        $this->senderName = $senderName;
    }

    public function client()
    {
        return new KobikomClient($this->apiKey);
    }

    public function send(): SmsDriverResponse
    {
        return $this->client()->send($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
