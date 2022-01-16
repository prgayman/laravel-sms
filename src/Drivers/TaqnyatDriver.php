<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\Clients\TaqnyatClient;

class TaqnyatDriver extends Driver
{

    /**
     * Authorization bearer token
     * @var string
     */
    protected $authorization;

    /**
     * Taqnyat instance client
     * @var \Prgayman\Sms\Clients\TaqnyatClient
     */
    protected $client;

    /**
     * Create a new log transport instance.
     *
     * @return void
     */
    public function __construct(string $authorization)
    {
        $this->client = new TaqnyatClient($authorization);
    }

    /** 
     * 
     * @throws \Prgayman\Sms\Exceptions\ClientException
     * @return \Illuminate\Http\Client\Response 
     */
    public function send()
    {
        return $this->client->sendSingleSms($this->getMessage(), $this->getFrom(), $this->getTo());
    }
}
