<?php

namespace Prgayman\Sms\Channels;

use Illuminate\Notifications\Notification;
use Prgayman\Sms\SmsNotification;

class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        $sms = $notification->toSms($notifiable);

        if ($sms instanceof SmsNotification) {
            return $sms->send();
        }

        return $sms;
    }
}
