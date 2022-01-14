<?php

namespace Prgayman\Sms\Clients;

class JawalSmsClient
{

    /**
     * Username
     * @var string
     */
    protected $username;

    /**
     * Password
     * @var string
     */
    protected $password;

    /**
     * Api Base Url
     */
    protected $baseUrl = 'http://www.jawalsms.net/';


    public function __construct(string $username, string $password)
    {
    }
}
