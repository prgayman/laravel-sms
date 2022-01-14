<?php

namespace Prgayman\Sms;

use InvalidArgumentException;
use Prgayman\Sms\Contracts\DriverInterface;
use Prgayman\Sms\Traits\CreateDriver;

class SmsManager
{
    use CreateDriver;

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved drivers.
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * The array of supported drivers.
     *
     * @var array
     */
    protected $supportedDrivers = ["log", "array"];

    /**
     * Create a new Sms manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a Driver instance by name.
     *
     * @param string|null  $name
     * @return \Prgayman\Sms\Contracts\DriverInterface
     */
    public function driver($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->drivers[$name] = $this->get($name);
    }

    /**
     * Attempt to get the driver from the local cache.
     *
     * @param  string  $name
     * @return \Prgayman\Sms\Contracts\DriverInterface
     */
    protected function get($name)
    {
        return $this->drivers[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given driver.
     *
     * @param string $name
     * @return \Prgayman\Sms\Contracts\DriverInterface
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $config = $this->configurationFor($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Driver [{$name}] is not defined.");
        }

        if (isset($config['handler'])) {
            if ($config['handler'] instanceof DriverInterface) {
                $driver = new $config['handler'];
            } else {
                throw new InvalidArgumentException("Driver [{$name}] is instanceof [\Prgayman\Sms\Contracts\DriverInterface].");
            }
        } else {
            if (!in_array($config['driver'] ?? $name, $this->supportedDrivers)) {
                throw new InvalidArgumentException("Driver [{$name}] is not supported or not have handler.");
            } else {
                $driverName = str_replace(" ", "", ucwords(str_replace('_', '', $config['driver'] ?? $name)));
                $driver = $this->{"create{$driverName}Driver"}($config);
            }
        }

        return $driver;
    }

    /**
     * @return array
     */
    public function getDrivers()
    {
        return $this->drivers;
    }

    /**
     * Get the sms connection configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function configurationFor($name)
    {
        return $this->app['config']["sms.drivers.{$name}"];
    }

    /**
     * Get the default sms driver name.
     *
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.default'];
    }

    /**
     * Set the default sms driver name.
     *
     * @param string $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['sms.default'] = $name;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
