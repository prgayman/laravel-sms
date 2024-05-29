<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\JorMallClient;
use Prgayman\Sms\Contracts\DriverMultipleContactsInterface;
use Prgayman\Sms\SmsDriverResponse;

class JorMallDriver extends Driver implements DriverMultipleContactsInterface
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
     * Create a new log transport instance.
     *
     * @param string $accName
     * @param string $password
     * @param string|null $senderId
     */
    public function __construct(string $accName, string $password, ?string $senderId = null)
    {
        $this->accName = $accName;
        $this->password = $password;
        $this->senderName = $senderId;
    }

    public function client()
    {
        return new JorMallClient($this->accName, $this->password);
    }

    public function send(): SmsDriverResponse
    {
        return $this->client()->send($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
