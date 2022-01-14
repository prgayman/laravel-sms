<?php

namespace Prgayman\Sms;

use Illuminate\Support\ServiceProvider;

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

        $this->app->bind('sms', function ($app) {
            return $app->make('sms.manager')->driver();
        });
    }
}
