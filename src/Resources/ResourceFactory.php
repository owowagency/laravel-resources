<?php

namespace OwowAgency\LaravelResources\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\MissingValue;
use OwowAgency\LaravelResources\Models\ResourceModel;
use OwowAgency\LaravelResources\Resources\ResourceResource;

class ResourceFactory
{
    /**
     * The default resource class.
     */
    public $defaultResourceClass = ResourceResource::class;

    /**
     * The mapping of model to resource.
     *
     * @var string
     */
    public $modelResource;

    /**
     * Create a new resource factory instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->modelResource = config('laravelresources.resource_factory');
    }

    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  boolean  $collection
     * @return mixed
     *
     * @throws \Exception
     */
    public function make($model, $collection = false)
    {
        if (is_null($model)) {
            return $model;
        }

        if ($model instanceof MissingValue) {
            return $model;
        }

        $modelClass = $this->getModelClass($model, $collection);

        $resourceClass = $this->getResourceClass($modelClass);

        if (! $collection) {
            $resource = new $resourceClass($model);
        } else {
            $resource = $resourceClass::collection($model);
        }

        return $resource;
    }

    /**
     * Get the class of the specified model.
     *
     * @param  string  $model
     * @param  boolean  $collection
     * @return string
     */
    public function getModelClass($model, $collection = false)
    {
        if (is_null($model)) {
            return ResourceModel::class;
        }

        if ($collection) {
            if (count($model) == 0) {
                return ResourceModel::class;
            } else {
                $model = $model[0];
            }
        }

        return get_class($model);
    }

    /**
     * Get the resource class by model class.
     *
     * @param  string  $modelClass
     * @return mixed
     */
    public function getResourceClass($modelClass)
    {
        return data_get(
            $this->modelResource,
            $modelClass,
            $this->defaultResourceClass
        );
    }
}
