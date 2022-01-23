<?php

namespace Prgayman\Sms\Events;

class MessageFailed
{
    /**
     * Error message
     * @var string
     */
    public $errorMessage;

    /**
     * Message data
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     * @return void
     */
    public function __construct(array $data, string $errorMessage)
    {
        $this->data         = $data;
        $this->errorMessage = $errorMessage;
    }
}
