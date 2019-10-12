<?php

namespace Revolution\Soracom\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Config;

use Revolution\Soracom\Client;
use Revolution\Soracom\Contracts\Factory;

class SoracomProductServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/soracom.php' => config_path('soracom.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/soracom.php', 'soracom'
        );

        $this->app->singleton(Factory::class, function ($app) {
            return new Client(Config::get('soracom'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            Factory::class,
        ];
    }
}
