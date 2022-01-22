<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Contracts\DriverInterface;

abstract class Driver implements DriverInterface
{
    /**
     * Sender Name
     * @var string
     */
    protected $from;

    /**
     * Recipient 
     * 
     * @var string
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

    public function to(string $mobile)
    {
        $this->to = $mobile;
        return $this;
    }

    public function from(string $senderName)
    {
        $this->from = $senderName;
        return $this;
    }

    public function message(string $message)
    {
        $this->text = $message;
        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getFrom()
    {
        return is_null($this->from) && !is_null($this->senderName) ? $this->senderName : $this->from;
    }

    public function getMessage()
    {
        return $this->text;
    }
}
