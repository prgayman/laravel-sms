<?php

namespace Prgayman\Sms\Drivers;

use Prgayman\Sms\SmsDriverResponse;
use Psr\Log\LoggerInterface;

class LogDriver extends Driver
{
    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new log driver instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get the logger for the LogDriver instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        return $this->logger;
    }

    public function send(): SmsDriverResponse
    {
        $request = [
            "from" => $this->getFrom(),
            "to" => $this->getTo(),
            "message" => $this->getMessage(),
        ];
        $response = $this->logger->debug($this->getEntityString($request));
        return new SmsDriverResponse($request, $response, true);
    }

    /**
     * Get a loggable string 
     * @return string
     */
    protected function getEntityString(array $request)
    {
        return (string) __CLASS__ . PHP_EOL . "[From]: {$request['from']}" . PHP_EOL . "[To]: {$request['to']}" . PHP_EOL . "[Message]: {$request['message']}";
    }
}
