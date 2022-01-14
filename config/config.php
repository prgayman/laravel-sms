<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default driver that is used to send any sms
    | messages sent by your application. Alternative drivers may be setup
    | and used as needed; however, this driver will be used by default.
    |
    */
    "default" => env('SMS_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Drivers Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the drivers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | "prgayman/laravel-sms" supports a variety of sms "driver" drivers to be used while
    | sending an sms. You will specify which one you are using for your
    | drivers below. You are free to add additional drivers as required.
    |
    | Supported: log
    |
    */
    "drivers" => [
        "log" => [
            "driver" => "log",
            'channel' => env('SMS_LOG_CHANNEL'),
        ],
    ]
];
