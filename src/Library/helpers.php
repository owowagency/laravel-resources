<?php

if (! function_exists('resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  boolean  $isCollection
     * @return mixed
     */
    function resource($model, $isCollection = false)
    {
        return (new \OwowAgency\LaravelResources\Resources\ResourceFactory)->make($model, $isCollection);
    }
}

if (! function_exists('manager')) {
    /**
     * Makes the manager for the specified model class.
     *
     * @param  string  $modelClass
     * @return mixed
     */
    function manager($modelClass)
    {
        return (new \OwowAgency\LaravelResources\Managers\ManagerFactory)->make($modelClass);
    }
}

if (! function_exists('repository')) {
    /**
     * Makes the repository for the specified model class.
     *
     * @param  string  $modelClass
     * @return \OwowAgency\LaravelResources\Repositories\Contracts\BaseRepositoryContract
     */
    function repository($modelClass)
    {
        return (new \OwowAgency\LaravelResources\Repositories\RepositoryFactory)->make($modelClass);
    }
}