<?php

namespace Prgayman\Sms;

class SmsDriverResponse
{

    /**
     * Sms paylaod
     * 
     * @var array
     */
    protected $request;

    /**
     * Sms driver response
     * @var mixed
     */
    protected $response;

    /**
     * Sms error or success message
     * 
     * @var string|null
     */
    protected $message;

    /**
     * Sms successful
     * 
     * @var bool
     */
    protected $succeeded;

    public function __construct(array $request, $response, bool $succeeded = false, ?string $message = null)
    {
        $this->request = $request;
        $this->response = $request;
        $this->succeeded = $succeeded;
        $this->message = $message;
    }

    /**
     * Get sms provider request
     * 
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * Get sms provider response
     * 
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get message
     * 
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Check is successfuly send sms message
     * 
     * @return bool
     */
    public function successful(): bool
    {
        return $this->succeeded;
    }

    /**
     * Check is failed send sms message
     * 
     * @return bool
     */
    public function failed(): bool
    {
        return !$this->successful();
    }
}
