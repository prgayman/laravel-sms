<?php

namespace Prgayman\Sms;

use Illuminate\Support\Arr;

class SmsConfig
{
    private static $config;

    public static function all()
    {
        if (is_null(self::$config)) {
            self::$config = config('sms');
        }
        return self::$config;
    }

    public static function config($key, $default = null)
    {
        return Arr::get(self::all(), $key, $default);
    }

    public static function historyEnabled(): bool
    {
        return static::config('history.enabled', false);
    }

    public static function historyStatuses(): array
    {
        return static::config('history.statuses', []);
    }
}
