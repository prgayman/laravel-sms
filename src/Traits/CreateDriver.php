<?php

namespace Prgayman\Sms\Traits;

use Prgayman\Sms\Drivers\LogDriver;
use Illuminate\Log\LogManager;
use Prgayman\Sms\Drivers\ArrayDriver;
use Prgayman\Sms\Drivers\JawalSmsDriver;
use Prgayman\Sms\Drivers\NexmoDriver;
use Prgayman\Sms\Drivers\TaqnyatDriver;
use Prgayman\Sms\Drivers\TwilioDriver;
use Psr\Log\LoggerInterface;

trait CreateDriver
{
    /**
     * Create an instance of the Log driver.
     * @param array $config
     * @return \Prgayman\Sms\Drivers\LogDriver
     */
    protected function createLogDriver(array $config)
    {
        $logger = $this->app->make(LoggerInterface::class);

        if ($logger instanceof LogManager) {
            $logger = $logger->channel($config['channel'] ?? null);
        }

        return new LogDriver($logger);
    }

    /**
     * Create an instance of the Array Driver.
     * @return \Prgayman\Sms\Drivers\ArrayDriver
     */
    protected function createArrayDriver(array $config)
    {
        return new ArrayDriver();
    }

    /**
     * Create an instance of the JawalbSmsWs Driver.
     * @return \Prgayman\Sms\Drivers\JawalSmsDriver
     */
    protected function createJawalSmsDriver(array $config)
    {
        return new JawalSmsDriver(
            $config["username"],
            $config["password"],
            $config["sender"] ?? null
        );
    }

    /**
     * Create an instance of the TaqnyatDriver Driver.
     * @return \Prgayman\Sms\Drivers\TaqnyatDriver
     */
    protected function createTaqnyatDriver(array $config)
    {
        return new TaqnyatDriver(
            $config["authorization"],
            $config["sender"] ?? null
        );
    }

    /**
     * Create an instance of the NexmoDriver Driver.
     * @return \Prgayman\Sms\Drivers\NexmoDriver
     */
    protected function createNexmoDriver(array $config)
    {
        return new NexmoDriver(
            $config["api_key"],
            $config["api_secret"],
            $config["sender"] ?? null
        );
    }

    /**
     * Create an instance of the TwilioDriver Driver.
     * @return \Prgayman\Sms\Drivers\TwilioDriver
     */
    protected function createTwilioDriver(array $config)
    {
        return new TwilioDriver(
            $config["sid"],
            $config["token"],
            $config["sender"] ?? null
        );
    }
}
