<?php

namespace Prgayman\Sms\Drivers;

use Illuminate\Support\Collection;
use Prgayman\Sms\Drivers\Driver;
use Prgayman\Sms\SmsDriverResponse;

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

    public function send(): SmsDriverResponse
    {
        $request = [
            "from"    => $this->getFrom(),
            "to"      => $this->getTo(),
            "message" => $this->getMessage()
        ];

        $this->messages[] = $request;

        return new SmsDriverResponse($request, null, true);
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
