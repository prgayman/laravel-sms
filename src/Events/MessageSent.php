<?php

namespace Prgayman\Sms\Events;

class MessageSent
{
    /**
     * Message data
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data  = $data;
    }
}
