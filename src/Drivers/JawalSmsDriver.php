<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\JawalSmsClient;
use Prgayman\Sms\SmsDriverResponse;

class JawalSmsDriver extends Driver
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
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $username, string $password, ?string $senderName = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->senderName = $senderName;
    }

    public function client()
    {
        return new JawalSmsClient($this->username, $this->password);
    }

    public function send(): SmsDriverResponse
    {
        return $this->client()->sendSingleSms($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
