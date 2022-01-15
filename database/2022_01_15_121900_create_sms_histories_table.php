<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Prgayman\Sms\Models\SmsHistory;

class CreateSmsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->getTable(), function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('driver');
            $table->string('driver_name');
            $table->string('message');
            $table->string('from');
            $table->string('to');
            $table->enum('status', [SmsHistory::SUCCESSED, SmsHistory::FAILED]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }

    protected function getTable(): string
    {
        return (new SmsHistory())->getTable();
    }
}
