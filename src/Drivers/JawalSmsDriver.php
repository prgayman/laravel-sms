<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\JawalSmsClient;

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
     * JawalSms instance clients
     * @var \Prgayman\Sms\Clients\JawalSmsClient
     */
    protected $client;

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $username, string $password, ?string $sender = null)
    {
        $this->from = $sender;

        $this->client = new JawalSmsClient($username, $password);
    }

    public function send()
    {
        // $from = $this->getFrom();
        // $to = $this->getTo();
        // $message = $this->getMessage();

        // $this->client->sendSingleSms($message, $from, $to);
    }
}
