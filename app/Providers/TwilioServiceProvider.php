<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/twilio.php', 'twilio'
        );
        
        $this->app->singleton(Client::class, function ($app) {
            return new Client(
                config('twilio.sid'),
                config('twilio.token')
            );
        });
        
        $this->app->bind('twilio', function ($app) {
            return $app->make(Client::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/twilio.php' => config_path('twilio.php'),
            ], 'twilio-config');
        }
    }
}
