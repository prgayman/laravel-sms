<?php

namespace Prgayman\Sms;

use Exception;
use Illuminate\Support\Str;
use Prgayman\Sms\Contracts\DriverInterface;
use Prgayman\Sms\Exceptions\DriverException;
use Prgayman\Sms\Models\SmsHistory;
use Illuminate\Contracts\Events\Dispatcher;

class SmsDriver implements DriverInterface
{
    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher|null
     */
    protected $events;

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

    public function __construct(DriverInterface $driver, string $name, array $config, Dispatcher $events = null)
    {
        $this->driver = $driver;
        $this->name = $name;
        $this->config = $config;
        $this->events = $events;
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
        $data = $this->payload();
        try {
            $this->dispatchSendingEvent($data);

            $response = $this->driver->send();

            $this->addHistory($data, SmsHistory::SUCCESSED);
            $this->dispatchSentEvent($data);

            return $response;
        } catch (Exception $e) {
            $this->addHistory($data, SmsHistory::FAILED);
            $this->dispatchFailedEvent($data, $e->getMessage());
            throw new DriverException($e->getMessage());
        }
    }

    /**
     * Add row to history if history enabled
     * 
     * @param array $data
     * @param string $status
     * @return bool
     */
    protected function addHistory(array $data, string $status): bool
    {
        if (SmsConfig::history("enabled", false) && in_array($status, SmsConfig::history("statuses", []))) {
            $data['id'] = Str::uuid()->toString();
            $data['status'] = $status;
            $history = app(SmsHistory::class)::create($data);
            return $history ? true : false;
        }
        return false;
    }

    /**
     * Dispatch message failed event
     * 
     * @param array $data
     * @param string $message
     * @return void
     */
    protected function dispatchFailedEvent(array $data, string $message)
    {
        if (isset($this->events)) {
            $event = SmsConfig::events('message_failed');
            if ($event) {
                $this->events->dispatch(new $event(
                    $data,
                    $message
                ));
            }
        }
    }

    /**
     * Dispatch message sending event
     * 
     * @param array $data
     * @return void
     */
    protected function dispatchSendingEvent(array $data)
    {
        if (isset($this->events)) {
            $event = SmsConfig::events('message_sending');
            if ($event) {
                $this->events->dispatch(new $event(
                    $data
                ));
            }
        }
    }

    /**
     * Dispatch message sent event
     * 
     * @param array $data
     * @return void
     */
    protected function dispatchSentEvent(array $data)
    {
        if (isset($this->events)) {
            $event = SmsConfig::events('message_sent');
            if ($event) {
                $this->events->dispatch(new $event(
                    $data
                ));
            }
        }
    }

    /** @return array */
    protected function payload(): array
    {
        return [
            "driver"      => $this->config['driver'] ?? $this->name,
            "driver_name" => $this->name,
            "message"     => $this->getMessage(),
            "from"        => $this->getFrom(),
            "to"          => $this->getTo()
        ];
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
