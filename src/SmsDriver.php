<?php

namespace Prgayman\Sms;

use Exception;
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

    /**
     * Set to 
     * 
     * @param string $mobile
     * @return $this
     */
    public function to(string $mobile): SmsDriver
    {
        $this->driver->to($mobile);
        return $this;
    }

    /**
     * Set from (sender name) 
     * 
     * @param string $senderName
     * @return $this
     */
    public function from(string $senderName): SmsDriver
    {
        $this->driver->from($senderName);
        return $this;
    }

    /**
     * Set message 
     * 
     * @param string $message
     * @return $this
     */
    public function message(string $message): SmsDriver
    {
        $this->driver->message($message);
        return $this;
    }

    /**
     * Get to 
     * 
     * @return string
     */
    public function getTo(): string
    {
        return $this->driver->getTo();
    }

    /**
     * Get from (sender name)
     * 
     * @return string
     */
    public function getFrom(): string
    {
        return $this->driver->getFrom();
    }

    /**
     * Get message content
     * 
     * @return string
     */
    public function getMessage(): string
    {
        return $this->driver->getMessage();
    }

    /**
     * Send Message
     * 
     * @throws Prgayman\Sms\Exceptions\DriverException
     * @return mixed
     */
    public function send()
    {
        try {
            $response = $this->driver->send();
            return $response;
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
