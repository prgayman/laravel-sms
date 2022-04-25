<?php

namespace Prgayman\Sms;

use Exception;
use Illuminate\Support\Str;
use Prgayman\Sms\Contracts\DriverInterface;
use Prgayman\Sms\Models\SmsHistory;
use Illuminate\Contracts\Events\Dispatcher;
use Prgayman\Sms\Contracts\DriverMultipleContactsInterface;

class SmsDriver implements DriverInterface
{
    /**
     * The event dispatcher instance.
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
     * Set type
     * @param string $type
     * @return $this
     */
    public function type(string $type): SmsDriver
    {
        $this->driver->type($type);
        return $this;
    }

    /**
     * Set to
     * @param array|string $to
     * @return $this
     */
    public function to(array|string $to): SmsDriver
    {
        $to = is_array($to) && count($to) == 1 ? $to[0] : $to;

        $this->driver->to($to);
        return $this;
    }

    /**
     * Set from (sender name)
     * @param string|null $senderName
     * @return $this
     */
    public function from(string|null $senderName): SmsDriver
    {
        $this->driver->from($senderName);
        return $this;
    }

    /**
     * Set message
     * @param string $message
     * @return $this
     */
    public function message(string $message): SmsDriver
    {
        $this->driver->message($message);
        return $this;
    }

    /**
     * Get type
     * @return string
     */
    public function getType(): string
    {
        return $this->driver->getType();
    }

    /**
     * Get to
     * @return array|string|null
     */
    public function getTo(): array|string|null
    {
        return $this->driver->getTo();
    }

    /**
     * Get from (sender name)
     * @return string|null
     */
    public function getFrom(): string|null
    {
        return $this->driver->getFrom();
    }

    /**
     * Get message content
     * @return string|null
     */
    public function getMessage(): string|null
    {
        return $this->driver->getMessage();
    }

    /**
     * Send Message
     * @return \Prgayman\sms\SmsDriverResponse
     */
    public function send(): SmsDriverResponse
    {
        $data = $this->payload();

        if (is_array($data["to"]) && !($this->driver instanceof DriverMultipleContactsInterface)) {
            throw new Exception("Driver [{$this->name}] can't supported send to multiple contacts.");
        }

        $this->dispatchSendingEvent($data);

        $response = $this->driver->send();

        if ($response->successful()) {
            $this->dispatchSentEvent($data);
            $this->addHistory($data, SmsHistory::SUCCESSED);
        } else {
            $this->dispatchFailedEvent($data, $response->getMessage());
            $this->addHistory($data, SmsHistory::FAILED, $response->getMessage());
        }

        return $response;
    }

    /**
     * Send multiple messages
     * @param $items must contain message, to, and from keys per item
     * @return \Prgayman\sms\SmsDriverResponse[]
     */
    public function sendArray(array $items)
    {
        $responses = [];

        foreach ($items as $index => $item) {
            if (isset($item['message']) && isset($item['to'])) {
                $responses[$index] = $this->to($item['to'])
                    ->from($item['from'] ?? null)
                    ->message($item['message'])
                    ->send();
            }
        }

        return $responses;
    }

    /**
     * Add row to history if history enabled
     * @param array $data
     * @param string $status
     * @return bool
     */
    protected function addHistory(array $data, string $status, ?string $exception = null): bool
    {
        if (
            SmsConfig::history("enabled", false) &&
            in_array($status, SmsConfig::history("statuses", [])) &&
            in_array($data['type'], SmsConfig::history("types", [])) &&
            !is_array($data['to'])
        ) {
            $data['id'] = Str::uuid()->toString();
            $data['status'] = $status;
            $data['exception'] = $exception;
            $history = app(SmsHistory::class)::create($data);
            return $history ? true : false;
        }
        return false;
    }

    /**
     * Dispatch message failed event
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
            "type"        => $this->getType(),
            "from"        => $this->getFrom(),
            "to"          => $this->getTo(),
            "message"     => $this->getMessage()
        ];
    }

    /**
     * Dynamically call the driver instance.
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver->$method(...$parameters);
    }
}
