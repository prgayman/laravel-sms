<?php

namespace Prgayman\Sms\Drivers;

use Exception;
use Illuminate\Support\Collection;
use Prgayman\Sms\Drivers\Driver;
use Prgayman\Sms\Exceptions\DriverException;

class ArrayDriver extends Driver
{
    /**
     * The collection of Sms Messages.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $messages;

    /**
     * Create a new array driver instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->messages = new Collection;
    }

    public function send()
    {
        try {
            $this->messages[] = [
                "driver"  => (string) __CLASS__,
                "from"    => $this->getFrom(),
                "to"      => $this->getTo(),
                "message" => $this->getMessage()
            ];
        } catch (Exception $e) {
            throw new DriverException($e->getMessage());
        }
    }

    /**
     * Retrieve the collection of messages.
     *
     * @return \Illuminate\Support\Collection
     */
    public function messages()
    {
        return $this->messages;
    }
}
