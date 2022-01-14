<?php

namespace Prgayman\Sms\Drivers;

use Exception;
use Prgayman\Sms\Exceptions\DriverException;


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
    public function __construct(string $username, string $password, ?string $sender = null)
    {
        $this->from = $sender;
    }

    public function send()
    {
        try {
        } catch (Exception $e) {
            throw new DriverException($e->getMessage());
        }
    }
}
