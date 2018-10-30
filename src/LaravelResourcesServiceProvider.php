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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'OwowAgency');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'OwowAgency');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

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

        // Register the service the package provides.
        $this->app->singleton('laravelresources', function ($app) {
            return new LaravelResources;
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
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelresources.php' => config_path('laravelresources.php'),
        ], 'laravelresources');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/OwowAgency'),
        ], 'laravelresources.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/OwowAgency'),
        ], 'laravelresources.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/OwowAgency'),
        ], 'laravelresources.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
