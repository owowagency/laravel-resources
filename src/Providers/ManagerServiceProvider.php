<?php

namespace OwowAgency\LaravelResources\Providers;

class ManagerServiceProvider extends BaseResourcesServiceProvider
{
    /**
     * The managers mappings for the application.
     *
     * @var array
     */
    protected $managers = [];

    /**
     * Get the items defined on the provider.
     *
     * @return array
     */
    public function getDefinableItems()
    {
        return $this->managers;
    }

    /**
     * Get the type to make a definable class for.
     *
     * @return string
     */
    protected function getType()
    {
        return 'managers';
    }
}
