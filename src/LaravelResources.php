<?php

namespace OwowAgency\LaravelResources;

use Illuminate\Contracts\Container\Container;

class LaravelResources
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * All types which have a definable type.
     *
     * @var array
     */
    protected $definable = [
        'resources',
    ];

    /**
     * The list of resources.
     *
     * @var array
     */
    protected $resources = [];

    /**
     * LaravelResources constructor.
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Define a executable class for a given model and the type of class.

     *
     * @param  string  $type
     * @param  string  $model
     * @param  string  $value
     * @return \OwowAgency\LaravelResources\LaravelResources
     */
    public function defineFor($type, $model, $value)
    {
        if (! in_array($type, $this->definable)) {
            return;
        }

        $this->$type[$model] = $value;

        return $this;
    }

    /**
     * Get a resource instance for a given model.
     *
     * @param  object|string  $model
     */
    public function getResourceFor($model)
    {
        return $this->getDefinableFor('resources', $model);
    }

    /**
     * Get a definable instance for a given model.
     *
     * @param  object|string  $model
     */
    protected function getDefinableFor($type, $model)
    {
        if (is_object($model)) {
            $model = get_class($model);
        }

        if (! is_string($model)) {
            return;
        }

        if (isset($this->$type[$model])) {
            return $this->resolveDefinable($this->$type[$model]);
        }
    }

    /**
     * Build a definable instance of the given type.
     *
     * @param  object|string  $class
     */
    protected function resolveDefinable($class)
    {
        return $this->container->make($class);
    }
}
