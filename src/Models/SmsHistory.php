<?php

namespace Prgayman\Sms\Models;

use Illuminate\Database\Eloquent\Model;
use Prgayman\Sms\SmsConfig;

class SmsHistory extends Model
{

    public const SUCCESSED = "successed";
    public const FAILED = "failed";

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The guarded attributes on the model.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable(): string
    {
        if (!$this->table) {
            $this->table = SmsConfig::smsHistories("table", "sms_histories");
        }

        return parent::getTable();
    }

    public function scopeStatus($query, $status)
    {
        $query->where("status", $status);
    }

    public function scopeDriver($query, $driver)
    {
        $query->where("driver", $driver);
    }

    public function scopeDriverName($query, $driverName)
    {
        $query->where("driver_name", $driverName);
    }

    public function scopeFrom($query, $from)
    {
        $query->where("from", $from);
    }

    public function scopeTo($query, $to)
    {
        $query->where("to", $to);
    }
}
