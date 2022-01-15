<?php



if (!function_exists("sms")) {

    /**
     * Helper function sms
     * 
     * @param string|null $driver
     * @return \Prgayman\Sms\Contracts\DriverInterface
     */
    function sms($driver = null)
    {
        return app("sms.manager")->driver($driver);
    }
}
