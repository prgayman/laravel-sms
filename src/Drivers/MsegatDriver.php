<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\MsegatClient;
use Prgayman\Sms\Contracts\DriverMultipleContactsInterface;
use Prgayman\Sms\SmsDriverResponse;

class MsegatDriver extends Driver implements DriverMultipleContactsInterface {
    /**
     * Username
     * @var string
     */
    protected $username;

    /**
     * Api Key
     * @var string
     */
    protected $apiKey;

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $username, string $apiKey, ?string $senderName = null) {
        $this->username = $username;
        $this->apiKey = $apiKey;
        $this->senderName = $senderName;
    }

    public function client() {
        return new MsegatClient($this->username, $this->apiKey);
    }

    public function send(): SmsDriverResponse {
        return $this->client()->send($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
