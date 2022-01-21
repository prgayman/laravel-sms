<?php

if (!function_exists("sms")) {

    /**
     * Helper function sms
     * 
     * @param string|null $driver
     * @return \Prgayman\Sms\SmsDriver
     */
    function sms($driver = null)
    {
        return app("sms.manager")->driver($driver);
    }
}

if (!function_exists("smsHistory")) {

    /**
     * Helper function sms history
     * 
     * @return \Prgayman\Sms\SmsHistory
     */
    function smsHistory()
    {
        return app("sms.history");
    }
}
