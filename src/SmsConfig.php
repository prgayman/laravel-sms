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

    public static function history($key, $default = null)
    {
        return static::config("history.{$key}", $default);
    }

    public static function smsHistories($key, $default = null)
    {
        return static::config("sms_histories.{$key}", $default);
    }

    public static function events($key, $default = null)
    {
        return static::config("events.{$key}", $default);
    }
}
