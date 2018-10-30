<?php

namespace OwowAgency\LaravelResources\Managers;

class ManagerFactory
{
    /**
     * The mapping of model to manager.
     *
     * @var string
     */
    public $modelManager;

    /**
     * The default manager class.
     */
    public $defaultManagerClass = ResourceManager::class;

    /**
     * Create a new manager factory instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modelManager = config('laravelresources.manager_factory');
    }

    /**
     * Makes the manager for the specified model class.
     *
     * @param  string  $modelClass
     * @return mixed
     *
     * @throws \Exception
     */
    public function make($modelClass)
    {
        $managerClass = $this->getManagerClass($modelClass);

        return new $managerClass($modelClass);
    }

    /**
     * Get the manager class by model class.
     *
     * @param  string  $modelClass
     * @return mixed
     */
    public function getManagerClass($modelClass)
    {
        return data_get(
            $this->modelManager,
            $modelClass,
            $this->defaultManagerClass
        );
    }
}
