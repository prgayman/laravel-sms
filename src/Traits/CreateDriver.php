<?php

namespace Prgayman\Sms\Traits;

use Prgayman\Sms\Drivers\LogDriver;
use Illuminate\Log\LogManager;
use Psr\Log\LoggerInterface;

trait CreateDriver
{
    /**
     * Create an instance of the Log driver.
     *
     * @param array $config
     * @return \Prgayman\Sms\Drivers\LogDriver
     */
    protected function createLogDriver(array $config)
    {
        $logger = $this->app->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel($config['channel']);
        }

        return new LogDriver($logger);
    }
}
