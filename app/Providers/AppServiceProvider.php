<?php

namespace App\Providers;

use Twilio\Rest\Client;
use App\Models\V1\Twilio;
use App\Models\V1\Mail\SMSLogging;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Translation\Translator;
use Illuminate\Support\ServiceProvider;
use App\Repositories\V1\SMSSendingInterface;
use App\Repositories\V1\SMSLoggingInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * In the current implementation we are relying only on one SMS service provider
         * This might be a SPOF if the service goes down.
         * An better more optimized way would be to use a fallback provider,
           that can be configured to if the service goes down for high availability.
         * This can be configured along with - Phystrix is a latency and fault tolerance library for PHP.
           https://github.com/upwork/phystrix
         */

        /*
         * We could also configure the two or more provider at the same time
         * The load can be distributed in a simple round robin fashion or
         * on the basis of cost of the provider
         */

        /*
         * Configure the Twilio Client
         * If we are using some other Client for SMS, it will need to be configured here
         */
        $this->app->bind(Client::class, function () {
            $twilioConfig = $this->app['config']->get('twilio');
            return new Client($twilioConfig['acctSid'], $twilioConfig['authToken']);
        });


        /*
         * The current implementation for sending sms uses the Twilio implementation
         * To change that just swap this SMS Sending implementation
         */
        $this->app->bind(SMSSendingInterface::class, function () {
            return new Twilio(
                app()->make(\Twilio\Rest\Client::class),
                app()->make(\Illuminate\Contracts\Logging\Log::class)
            );
        });

        // Easily  switch to different kind of data source for logging and not just RDBMS
        $this->app->bind(SMSLoggingInterface::class, function () {
            return new SMSLogging(
                app()->make(\Psr\Log\LoggerInterface::class)
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
