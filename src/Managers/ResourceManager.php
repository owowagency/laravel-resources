<?php

namespace owowagency\LaravelResources\Managers;

class ResourceManager extends BaseManager
{
    /**
     * ResourceManager constructor.
     *
     * @param  string  $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;

        $repository = repository($model);

        $this->repository = $repository;
    }

    /**
     * Handle dynamic method calls into the manager.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($method, $parameters)
    {
        if ($this->hasMethod($method)) {
            return $this->$method(...$parameters);
        } else if ($this->repositoryHasMethod($method)) {
            return $this->repository->$method(...$parameters);
        }

        throw new \Exception(sprintf(
            trans('exceptions.method_not_exists'),
            $method,
            get_class($this),
            get_class($this->repository)
        ));
    }

    /**
     * Checks if this has method.
     *
     * @param  string  $method
     * @return boolean
     */
    private function hasMethod($method)
    {
        return method_exists($this, $method);
    }

    /**
     * Checks if repository has method.
     *
     * @param  string  $method
     * @return boolean
     */
    private function repositoryHasMethod($method)
    {
        return method_exists($this->repository, $method);
    }
}
