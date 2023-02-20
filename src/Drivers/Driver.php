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
     * @var string|null
     */
    protected $senderName;

    /**
     * Driver options
     * @var array
     */
    protected $options = [];

    /**
     * Type message
     * @var string
     */
    protected $type = \Prgayman\Sms\SmsTypes::GENERAL;

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function from(?string $senderName = null)
    {
        $this->from = $senderName;
        return $this;
    }

    public function message(string $message)
    {
        $this->text = $message;
        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getFrom(): ?string
    {
        return is_null($this->from) && !is_null($this->senderName) ? $this->senderName : $this->from;
    }

    public function getMessage(): ?string
    {
        return $this->text;
    }
}
