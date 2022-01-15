<?php

namespace Prgayman\Sms;

use Exception;
use Illuminate\Support\Facades\Mail;
use Prgayman\Sms\Contracts\DriverInterface;
use Prgayman\Sms\Exceptions\DriverException;

class SmsDriver implements DriverInterface
{
    /**
     * Sms driver
     * @var \Prgayman\Sms\Contracts\DriverInterface
     */
    protected $driver;

    /**
     * Driver config
     * @var array
     */
    protected $config;

    /**
     * Driver string name
     * @var string
     */
    protected $name;

    public function __construct(DriverInterface $driver, string $name, array $config)
    {
        $this->driver = $driver;
        $this->name = $name;
        $this->config = $config;
    }

    public function to(string $mobile)
    {
        $this->driver->to($mobile);
        return $this;
    }

    public function from(string $senderName)
    {
        $this->driver->from($senderName);
        return $this;
    }

    public function message(string $message)
    {
        $this->driver->message($message);
        return $this;
    }

    public function getTo()
    {
        return $this->driver->getTo();
    }

    public function getFrom()
    {
        return $this->driver->getFrom();
    }

    public function getMessage()
    {
        return $this->driver->getMessage();
    }

    public function send()
    {
        try {
            $response = $this->driver->send();
        } catch (Exception $e) {
            throw new DriverException($e->getMessage());
        }
    }

    /**
     * Dynamically call the driver instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver->$method(...$parameters);
    }
}
