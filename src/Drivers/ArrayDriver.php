<?php

namespace Prgayman\Sms\Drivers;

use Illuminate\Support\Collection;
use Prgayman\Sms\Drivers\Driver;

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
        $this->messages[] = [
            "driver"  => (string) __CLASS__,
            "from"    => $this->getFrom(),
            "to"      => $this->getTo(),
            "message" => $this->getMessage()
        ];
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
