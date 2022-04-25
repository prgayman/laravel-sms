<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Prgayman\Sms\Models\SmsHistory;
use Prgayman\Sms\SmsTypes;

class AddColumnTypeToSmsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->getTable(), function (Blueprint $table) {
            $table->string('type')->default(SmsTypes::GENERAL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->getTable(), function (Blueprint $table) {
            $table->dropIfExists("type");
        });
    }

    protected function getTable(): string
    {
        return (new SmsHistory())->getTable();
    }
}
