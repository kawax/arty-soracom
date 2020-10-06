<?php

namespace Revolution\Soracom\Providers;

use Illuminate\Support\ServiceProvider;
use Revolution\Soracom\Client;
use Revolution\Soracom\Contracts\Factory;
use GuzzleHttp\Client as GuzzleClient;

class SoracomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/../config/soracom.php' => $this->app->configPath('soracom.php'),
            ]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/soracom.php',
            'soracom'
        );

        $this->app->singleton(
            Factory::class,
            function ($app) {
                return new Client(new GuzzleClient(), $app['config']->get('soracom'));
            }
        );
    }
}
