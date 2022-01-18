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

        $this->assertNotNull($response);
    }

    public function testSendSingleMessageWithSelectDriver()
    {
        $response = Sms::driver("array")
            ->to("+962792994123")
            ->from("SenderName")
            ->message("New Message")
            ->send();

        $this->assertNotNull($response);
    }
}
