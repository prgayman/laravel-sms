<?php

namespace Prgayman\Sms\Drivers;

class NexmoDriver extends Driver
{

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $apiKey, string $apiSecret, ?string $senderName = null)
    {
        config()->set('nexmo.api_key', $apiKey);
        config()->set('nexmo.api_secret', $apiSecret);
        $this->senderName = $senderName;
    }

    /**
     * Nexmo instance client
     * 
     * @return \Nexmo\Client
     */
    public function client()
    {
        return app('Nexmo\Client');
    }

    public function send()
    {
        return $this->client()->message()->send([
            'to' => $this->getTo(),
            'from' => $this->getFrom(),
            'text' => $this->getMessage(),
        ]);
    }
}
