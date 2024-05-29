<?php

namespace Prgayman\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getDrivers()
 * @method static string|null getDefaultDriver()
 * @method static void setDefaultDriver(string $name)
 * @method static \Prgayman\Sms\SmsDriver driver(string|null $name = null)
 * @method static \Prgayman\Sms\SmsDriver type(string $name)
 * @method static \Prgayman\Sms\SmsDriver to(array|string $mobile)
 * @method static \Prgayman\Sms\SmsDriver from(?string $senderName = null)
 * @method static \Prgayman\Sms\SmsDriver message(string $text)
 * @method static \Prgayman\Sms\SmsDriver options(array $options)
 * @method static array|string|null getTo()
 * @method static string|null getFrom()
 * @method static string|null getMessage()
 * @method static array getOptions()
 * @method static \Prgayman\Sms\SmsDriverResponse send()
 * @method static \Prgayman\Sms\SmsDriverResponse[] sendArray(array $messages)
 * @see \Prgayman\Sms\SmsManager
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms.manager';
    }
}
