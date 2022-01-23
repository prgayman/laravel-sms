<?php

namespace Prgayman\Sms;

class SmsConfig
{
    public static function config($key, $default = null)
    {
        return config("sms.{$key}", $default);
    }

    public static function set($key, $value)
    {
        return config()->set("sms.{$key}", $value);
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
