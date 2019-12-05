<?php

namespace Guetteman\LaravelTinkerServer;

use Guetteman\LaravelTinkerServer\Console\TinkerServerCommand;
use Illuminate\Support\ServiceProvider;

class LaravelTinkerServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-tinker-server.php'),
            ], 'config');

            $this->commands([
                TinkerServerCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-tinker-server');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-tinker-server', function () {
            return new LaravelTinkerServer;
        });
    }
}
