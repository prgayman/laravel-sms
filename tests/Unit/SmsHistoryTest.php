<?php

namespace Prgayman\Sms\Test\Unit;

use Prgayman\Sms\Facades\Sms;
use Prgayman\Sms\Facades\SmsHistory;
use Prgayman\Sms\Models\SmsHistory as ModelsSmsHistory;
use Prgayman\Sms\SmsConfig;
use Prgayman\Sms\Test\TestCase;

class SmsHistoryTest extends TestCase
{
    public function testStoreHistory()
    {
        SmsConfig::set("history.enabled", true);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        $this->assertDatabaseCount((new ModelsSmsHistory)->getTable(), 1);
    }

    public function testDisableStoreHistory()
    {
        SmsConfig::set("history.enabled", false);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        $this->assertDatabaseCount((new ModelsSmsHistory)->getTable(), 0);
    }

    public function testGetHistories()
    {

        SmsConfig::set("history.enabled", true);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        $histories = SmsHistory::get();

        $this->assertCount(2, $histories);
    }

    public function testGetHistoriesByFilterRecipients()
    {
        SmsConfig::set("history.enabled", true);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        Sms::to("+962792994121")
            ->from("SenderNewName")
            ->message($message)
            ->send();

        $histories = SmsHistory::recipients($to)->get();

        $this->assertCount(1, $histories);
    }

    public function testGetHistoriesByFilterSenders()
    {
        SmsConfig::set("history.enabled", true);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        Sms::to("+962792994121")
            ->from("SenderNewName")
            ->message($message)
            ->send();

        $histories = SmsHistory::senders($from)->get();

        $this->assertCount(1, $histories);
    }

    public function testGetHistoriesByFilterStatuses()
    {
        SmsConfig::set("history.enabled", true);

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        Sms::to("+962792994121")
            ->from("SenderNewName")
            ->message($message)
            ->send();

        $histories = SmsHistory::statuses(ModelsSmsHistory::FAILED)->get();

        $this->assertCount(0, $histories);
    }

    public function testGetHistoriesByFilterDrivers()
    {
        SmsConfig::set("history.enabled", true);
        SmsConfig::set("default", "log");

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        $histories = SmsHistory::drivers("array")->get();

        $this->assertCount(0, $histories);
    }

    public function testGetHistoriesByFilteDriverNames()
    {
        SmsConfig::set("history.enabled", true);
        SmsConfig::set("default", "log");

        $to = "+962792994123";
        $from = "SenderName";
        $message = "New Message";

        Sms::to($to)
            ->from($from)
            ->message($message)
            ->send();

        $histories = SmsHistory::driverNames("log")->get();

        $this->assertCount(1, $histories);
    }
}
