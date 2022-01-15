<?php

namespace Prgayman\Sms\Drivers;

use InvalidArgumentException;
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
        if (is_null($this->to)) {
            throw new InvalidArgumentException('The "to" value cannot be null');
        }
        return $this->to;
    }

    public function getFrom()
    {
        if (is_null($this->from)) {
            throw new InvalidArgumentException('The "from" value cannot be null');
        }
        return $this->from;
    }

    public function getMessage()
    {
        if (is_null($this->text)) {
            throw new InvalidArgumentException('The "message" value cannot be null');
        }
        return $this->text;
    }
}
