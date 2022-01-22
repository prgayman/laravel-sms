<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Contracts\DriverInterface;

abstract class Driver implements DriverInterface
{
    /**
     * Sender Name
     * @var string|null
     */
    protected $from;

    /**
     * Recipient 
     * 
     * @var array|string
     */
    protected $to;

    /**
     * Text message
     * @var string
     */
    protected $text;

    /**
     * Driver Sender Name
     * 
     * @var string|null
     */
    protected $senderName;

    public function to(array|string $to)
    {
        $this->to = $to;
        return $this;
    }

    public function from(string|null $senderName)
    {
        $this->from = $senderName;
        return $this;
    }

    public function message(string $message)
    {
        $this->text = $message;
        return $this;
    }

    public function getTo(): array|string|null
    {
        return $this->to;
    }

    public function getFrom(): string|null
    {
        return is_null($this->from) && !is_null($this->senderName) ? $this->senderName : $this->from;
    }

    public function getMessage(): string|null
    {
        return $this->text;
    }
}
