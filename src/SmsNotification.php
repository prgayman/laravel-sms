<?php

namespace Prgayman\Sms;

class SmsNotification
{

    /**
     * Sms driver
     * @var \Prgayman\Sms\Contracts\DriverInterface
     */
    protected $driver;

    public function __construct()
    {
        $this->driver = app('sms.manager');
    }

    /**
     * Get a Driver instance by name.
     *
     * @param string|null  $name
     * @return $this
     */
    public function driver($name = null): self
    {
        $this->driver = app('sms.manager')->driver($name);
        return $this;
    }

    /**
     * Set to 
     * 
     * @param string $mobile
     * @return $this
     */
    public function to(string $mobile): self
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
    public function from(string $senderName): self
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
    public function message(string $message): self
    {
        $this->driver->message($message);
        return $this;
    }

    /**
     * Send sms message
     * @return mixed
     */
    public function send()
    {
        return $this->driver->send();
    }
}
