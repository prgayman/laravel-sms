<?php

namespace Prgayman\Sms\Drivers;

use Exception;
use Prgayman\Sms\Exceptions\DriverException;
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

    public function send()
    {
        try {
            $this->logger->debug($this->getMimeEntityString());
        } catch (Exception $e) {
            throw new DriverException($e->getMessage());
        }
    }

    /**
     * Get a loggable string 

     * @return string
     */
    protected function getMimeEntityString()
    {
        return (string) __CLASS__ . PHP_EOL . "[FROM]: {$this->getFrom()}" . PHP_EOL . "[TO]: {$this->getTo()}" . PHP_EOL . "[MESSAGE]: {$this->getMessage()}";
    }
}
