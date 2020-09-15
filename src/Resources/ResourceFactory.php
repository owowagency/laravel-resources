<?php

namespace OwowAgency\LaravelResources\Resources;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Pagination\AbstractPaginator;
use OwowAgency\LaravelResources\Models\ResourceModel;

class ResourceFactory
{
    /**
     * The default resource class.
     *
     * @var string
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
     * @param  boolean  $isPlural
     * @return Illuminate\Http\Resources\Json\JsonResource
     *         | Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *         | Illuminate\Pagination\AbstractPaginator
     *
     * @throws \Exception
     */
    public function make($model, $isPlural = null)
    {
        // Return the model directly if it is invalid.
        if (is_null($model) || $model instanceof MissingValue) {
            return $model;
        }

        // Check if the model is plural (a collection or paginated).
        $isPlural = $isPlural
            ?? ($model instanceof Collection || $model instanceof AbstractPaginator);
        
        $modelClass = $this->getModelClass($model, $isPlural);

        $resourceClass = $this->getResourceClass($modelClass);

        // Based on the model's plurality, make the correct resource.
        if (! $isPlural) {
            $resource = new $resourceClass($model);
        } else {
            $resource = $resourceClass::collection($model);
        }

        // If the model is paginated, we return `AbstractPaginator` instance
        // with the resource as its collection.
        if ($model instanceof AbstractPaginator) {
            return $model->setCollection($resource->collection);
        }

        return $resource;
    }

    /**
     * Get the class of the specified model.
     *
     * @param  mixed  $model
     * @param  boolean  $isPlural
     * @return string
     */
    public function getModelClass($model, $isPlural = false)
    {
        if (is_null($model) || ! is_object($model)) {
            return ResourceModel::class;
        }

        if ($isPlural) {
            if (count($model) == 0) {
                return ResourceModel::class;
            } else {
                $model = Arr::first($model);
            }
        }

        return is_object($model)
            ? get_class($model)
            : ResourceModel::class;
    }

    /**
     * Get the resource class by model class.
     *
     * @param  string  $modelClass
     * @return mixed
     */
    public function getResourceClass($modelClass)
    {
        // Check if a resource class has been configured.
        $resourceClass = data_get(
            $this->modelResource,
            $modelClass,
        );

        if ($resourceClass !== null) {
            return $resourceClass;
        }

        // Try to guess the resource.
        $guess = sprintf(
            '%s\\%sResource',
            config('laravelresources.resource_namespace'),
            class_basename($modelClass),
        );

        if (class_exists($guess)) {
            return $guess;
        }

        return $this->defaultResourceClass;
    }
}
