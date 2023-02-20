<?php

namespace Prgayman\Sms\Contracts;

use Prgayman\Sms\SmsDriverResponse;

interface DriverInterface
{
    /**
     * Set mobile number's
     *
     * @param string|array $to
     * @return $this
     */
    public function to($to);

    /**
     * Set sender Name
     *
     * @param string $senderName
     * @return $this
     */
    public function from(string $senderName);

    /**
     * Set text message
     *
     * @param string $message
     * @return $this
     */
    public function message(string $message);

    /**
     * Set type message
     *
     * @param string $type
     * @return $this
     */
    public function type(string $type);

    /**
     * Set sms options
     *
     * @param array $options
     * @return $this
     */
    public function options(array $options);

    /**
     * Get to
     *
     * @return string|array
     */
    public function getTo();

    /**
     * Get sender name
     *
     * @return string|null
     */
    public function getFrom(): ?string;

    /**
     * Get text message
     *
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * get sms options
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Send Message
     *
     * @return \Prgayman\Sms\SmsDriverResponse
     */
    public function send(): SmsDriverResponse;
}
