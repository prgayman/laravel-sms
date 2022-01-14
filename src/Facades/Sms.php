<?php

namespace Prgayman\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 
 * @see \Prgayman\Sms\Sms
 */

class Sms extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Prgayman\Sms\Sms::class;
    }
}
