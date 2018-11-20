<?php

namespace OwowAgency\LaravelResources;

use Dingo\Api\Routing\Router;
use Illuminate\Support\ServiceProvider;
use OwowAgency\LaravelResources\Routing\ResourceRegistrar;

class LaravelResourcesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $registrar = new ResourceRegistrar($this->app[Router::class]);

        $this->app->bind('Dingo\Api\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravelresources.php', 'laravelresources');

        $this->publishes([
            __DIR__.'/../config/laravelresources.php' => config_path('laravelresources.php'),
        ], 'laravelresources');

        // Register the service the package provides.
        $this->app->singleton('laravelresources', function ($app) {
            return new LaravelResources($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelresources'];
    }
}
