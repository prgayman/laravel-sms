<?php

namespace Prgayman\Sms\Drivers;

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

    /** @return bool */
    public function send()
    {
        $this->logger->debug($this->getEntityString());
        return true;
    }

    /**
     * Get a loggable string 
     * @return string
     */
    protected function getEntityString()
    {
        return (string) __CLASS__ . PHP_EOL . "[From]: {$this->getFrom()}" . PHP_EOL . "[To]: {$this->getTo()}" . PHP_EOL . "[Message]: {$this->getMessage()}";
    }
}
