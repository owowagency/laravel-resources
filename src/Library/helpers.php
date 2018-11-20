<?php

if (! function_exists('resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $modelClass
     * @param  boolean  $isCollection
     * @return mixed
     */
    function resource($modelClass, $isCollection = false)
    {
        return \LaravelResources::getResourceFor($modelClass, $isCollection);
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
        return \LaravelResources::getManagerFor($modelClass);
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
        return \LaravelResources::getRepositoryFor($modelClass);
    }
}