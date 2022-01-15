<?php

namespace Prgayman\Sms;

use Illuminate\Support\ServiceProvider;
use Prgayman\Sms\Models\SmsHistory;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        # Load migration from database directory
        $this->loadMigrationsFrom([
            __DIR__ . '/../database'
        ]);

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

        $this->app->bind('sms', function ($app) {
            return $app->make('sms.manager')->driver();
        });
    }

    /**
     * Bind laravel-sms models
     * 
     * @return void
     */
    private function bindModels(): void
    {
        $this->app->bind(SmsHistory::class, config('sms.sms_histories.model'));
    }
}
