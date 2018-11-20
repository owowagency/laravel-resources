<?php

namespace OwowAgency\LaravelResources\Providers;

class RepositoryServiceProvider extends BaseResourcesServiceProvider
{
    /**
     * The managers mappings for the application.
     *
     * @var array
     */
    protected $repositories = [];

    /**
     * Get the items defined on the provider.
     *
     * @return array
     */
    public function getDefinableItems()
    {
        return $this->repositories;
    }

    /**
     * Get the type to make a definable class for.
     *
     * @return string
     */
    protected function getType()
    {
        return 'repositories';
    }
}
