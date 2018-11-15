<?php

namespace OwowAgency\LaravelResources\Providers;

use Illuminate\Support\ServiceProvider;
use OwowAgency\LaravelResources\Facades\LaravelResources;

abstract class BaseResourcesServiceProvider extends ServiceProvider
{
    /**
     * Register the application's definables.
     *
     * @return void
     */
    public function registerDefinables()
    {
        $type = $this->getType();

        foreach ($this->getDefinableItems() as $model => $value) {
            LaravelResources::defineFor($type, $model, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the items defined on the provider.
     *
     * @return array
     */
    public abstract function getDefinableItems();

    /**
     * Get the type to make a definable class for.
     *
     * @return string
     */
    protected abstract function getType();
}
