<?php

namespace OwowAgency\LaravelResources\Providers;

class ResourceServiceProvider extends BaseResourcesServiceProvider
{
    /**
     * The resources mappings for the application.
     *
     * @var array
     */
    protected $resources = [];

    /**
     * Get the items defined on the provider.
     *
     * @return array
     */
    public function getDefinableItems()
    {
        return $this->resources;
    }

    /**
     * Get the type to make a definable class for.
     *
     * @return string
     */
    protected function getType()
    {
        return 'resources';
    }
}
