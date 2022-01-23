<?php

namespace Prgayman\Sms;

use Prgayman\Sms\Models\SmsHistory as ModelsSmsHistory;

class SmsHistory
{
    /**
     * Sender Names
     * @var array|string
     */
    protected $senders;

    /**
     * Recipients
     * @var array|string
     */
    protected $recipients;

    /**
     * Message status
     * @var array|string
     */
    protected $statuses;

    /**
     * Drivers
     * @var array|string
     */
    protected $drivers;

    /**
     * Driver names
     * @var array|string
     */
    protected $driverNames;

    /**
     * Filter by recipients
     * @param array|string $recipients
     * @return $this
     */
    public function recipients($recipients): SmsHistory
    {
        $this->recipients = $recipients;
        return $this;
    }

    /**
     * Filter by senders
     * @param array|string $senders
     * @return $this
     */
    public function senders($senders): SmsHistory
    {
        $this->senders = $senders;
        return $this;
    }

    /**
     * Filter by statuses
     * @param array|string $statuses
     * @return $this
     */
    public function statuses($statuses): SmsHistory
    {
        $this->statuses = $statuses;
        return $this;
    }


    /**
     * Filter by drivers
     * @param array|string $drivers
     * @return $this
     */
    public function drivers($drivers): SmsHistory
    {
        $this->drivers = $drivers;
        return $this;
    }

    /**
     * Filter by driver name
     * @param array|string $driverNames
     * @return $this
     */
    public function driverNames($driverNames): SmsHistory
    {
        $this->driverNames = $driverNames;
        return $this;
    }

    /**
     * Get data
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get()
    {
        return ModelsSmsHistory::when(!is_null($this->recipients), function ($query) {
            $query->whereIn("to", is_array($this->recipients)
                ? $this->recipients
                : [$this->recipients]);
        })
            ->when(!is_null($this->senders), function ($query) {
                $query->whereIn("from", is_array($this->senders)
                    ? $this->senders
                    : [$this->senders]);
            })
            ->when(!is_null($this->statuses), function ($query) {
                $query->whereIn("status", is_array($this->statuses)
                    ? $this->statuses
                    : [$this->statuses]);
            })
            ->when(!is_null($this->drivers), function ($query) {
                $query->whereIn("driver", is_array($this->drivers)
                    ? $this->drivers
                    : [$this->drivers]);
            })
            ->when(!is_null($this->driverNames), function ($query) {
                $query->whereIn("driver_name", is_array($this->driverNames)
                    ? $this->driverNames
                    : [$this->driverNames]);
            })
            ->get();
    }
}
