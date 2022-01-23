<?php

namespace Prgayman\Sms\Contracts;

use Prgayman\Sms\SmsDriverResponse;

interface DriverInterface
{
    /**
     * Set mobile number's
     * @param array|string $to
     * @return $this
     */
    public function to(array|string $to);

    /**
     * Set sender Name
     * @param string $senderName
     * @return $this
     */
    public function from(string|null $senderName);

    /**
     * Set text message
     * @param string $message
     * @return $this
     */
    public function message(string $message);

    /**
     * Get to
     * @return array|string|null
     */
    public function getTo(): array|string|null;

    /**
     * Get sender name
     * @return string|null
     */
    public function getFrom(): string|null;

    /**
     * Get text message
     * @return string|null
     */
    public function getMessage(): string|null;

    /**
     * Send Message
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(): SmsDriverResponse;
}
