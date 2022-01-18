<?php

namespace Prgayman\Sms\Test\Unit;

use Prgayman\Sms\Facades\Sms;
use Prgayman\Sms\Test\TestCase;

class SmsTest extends TestCase
{

    public function testSetDefaultDriver()
    {
        Sms::setDefaultDriver("array");

        $this->assertEquals(Sms::getDefaultDriver(), "array");
    }

    public function testSendSingleMessageWithDefaultDriver()
    {
        $response = Sms::to("+962792994123")
            ->from("SenderName")
            ->message("New Message")
            ->send();

        $this->assertTrue($response->successful());
    }

    public function testSendSingleMessageWithSelectDriver()
    {
        $response = Sms::driver("array")
            ->to("+962792994123")
            ->from("SenderName")
            ->message("New Message")
            ->send();

        $this->assertTrue($response->successful());
    }

    public function testfailedSendMessage()
    {
        $this->app['config']->set("sms.drivers.twilio", [
            ...$this->app['config']->get("sms.drivers.twilio"),
            "sid" => "sid",
            "token" => "token"
        ]);

        $response = Sms::driver("twilio")
            ->to("+962792994123")
            ->from("SenderName")
            ->message("New Message")
            ->send();

        $this->assertTrue($response->failed());
    }

    public function testGetTo()
    {
        $phone = "+9627900000000";
        Sms::to($phone);

        $this->assertEquals(Sms::getTo(), $phone);
    }

    public function testGetFrom()
    {
        $from = "Sender name";
        Sms::from($from);

        $this->assertEquals(Sms::getFrom(), $from);
    }

    public function testGetMessage()
    {
        $message = "Test new message";
        Sms::message($message);

        $this->assertEquals(Sms::getMessage(), $message);
    }


    public function testRequestDataWithDefaultDriver()
    {
        $to = "+962792994123";
        $from = "SenderName";
        $message = "Test new message";
        $request = Sms::from($from)->to($to)->message($message)->send()->getRequest();

        $this->assertEquals($request['message'], $message);
        $this->assertEquals($request['from'], $from);
        $this->assertEquals($request['to'], $to);
    }

    public function testRequestDataWithSekectDriver()
    {
        $to = "+962792994123";
        $from = "SenderName";
        $message = "Test new message";
        $request = Sms::driver('array')->from($from)->to($to)->message($message)->send()->getRequest();

        $this->assertEquals($request['message'], $message);
        $this->assertEquals($request['from'], $from);
        $this->assertEquals($request['to'], $to);
    }


    public function testCheckUseDefaultSenderName()
    {
        $senderName = "Sender Name";

        $this->app['config']->set("sms.drivers.twilio", [
            ...$this->app['config']->get("sms.drivers.twilio"),
            "sender" => $senderName,
            "sid" => "sid",
            "token" => "token"
        ]);

        $driver =  Sms::driver("twilio");

        $this->assertEquals($driver->getFrom(), $senderName);
    }
}
