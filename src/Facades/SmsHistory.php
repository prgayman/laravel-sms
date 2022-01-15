<?php

namespace Prgayman\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Prgayman\Sms\SmsHistory recipients(array|string $recipients)
 * @method static Prgayman\Sms\SmsHistory senders(array|string $senders)
 * @method static Prgayman\Sms\SmsHistory statuses(array|string $statuses)
 * @method static Prgayman\Sms\SmsHistory drivers(array|string $drivers)
 * @method static Prgayman\Sms\SmsHistory driverNames(array|string $driverNames)
 * @method static \Illuminate\Database\Eloquent\Collection|static[] get()
 * 
 * @see \Prgayman\Sms\SmsHistory
 */
class SmsHistory extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms.history';
    }
}
