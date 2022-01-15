<?php

namespace Prgayman\Sms;

use Illuminate\Support\ServiceProvider;
use Prgayman\Sms\Models\SmsHistory as ModelsSmsHistory;
use Prgayman\Sms\SmsHistory;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        # publishes config file with group (laravel-sms-config)
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('sms.php'),
        ], 'laravel-sms-config');


        # publishes migrations with group (laravel-sms-migrations)
        $this->publishes([
            __DIR__ . '/../database/' => database_path('migrations'),
        ], 'laravel-sms-migrations');
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        # merge config from config file
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'sms'
        );

        $this->registerDriver();

        # Bind models
        $this->bindModels();
    }


    /**
     * Register the mailer instance.
     *
     * @return void
     */
    protected function registerDriver()
    {
        $this->app->singleton('sms.manager', function ($app) {
            return new SmsManager($app);
        });

        $this->app->singleton('sms.history', function ($app) {
            return new SmsHistory($app);
        });
    }

    /**
     * Bind laravel-sms models
     * 
     * @return void
     */
    private function bindModels(): void
    {
        $this->app->bind(ModelsSmsHistory::class, SmsConfig::smsHistories('model'));
    }
}
