<?php

namespace Prgayman\Sms\Test;

use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Get package providers.
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Prgayman\Sms\SmsServiceProvider::class,
        ];
    }

    /**
     * Override application aliases.
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Sms' => \Prgayman\Sms\Facades\Sms::class,
            'SmsHistory' => \Prgayman\Sms\Facades\SmsHistory::class,
        ];
    }

    /**
     * Define database migrations.
     * @return void
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database');
    }
}
