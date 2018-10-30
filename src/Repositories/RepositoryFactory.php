<?php

namespace OwowAgency\LaravelResources\Repositories;

use OwowAgency\LaravelResources\Repositories\ResourceRepository;
use OwowAgency\LaravelResources\Repositories\Contracts\BaseRepositoryContract;

class RepositoryFactory
{
    /**
     * The mapping of model to repository.
     *
     * @var string
     */
    public $modelRepository;

    /**
     * The default repository class.
     */
    public $defaultRepositoryClass = ResourceRepository::class;

    /**
     * Create a new repository factory instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->modelRepository = config('laravelresources.repository_factory');
    }

    /**
     * Makes the repository for the specified model class.
     *
     * @param  string  $modelClass
     * @return \OwowAgency\LaravelResources\Repositories\Contracts\BaseRepositoryContract
     *
     * @throws \Exception
     */
    public function make($modelClass) : BaseRepositoryContract
    {
        $repositoryClass = $this->getRepositoryClass($modelClass);

        return app($repositoryClass, [
            'resourceModelClass' => $modelClass
        ]);
    }

    /**
     * Get the repository class by model class.
     *
     * @param  string  $modelClass
     * @return mixed
     */
    public function getRepositoryClass($modelClass)
    {
        return data_get(
            $this->modelRepository,
            $modelClass,
            $this->defaultRepositoryClass
        );
    }
}