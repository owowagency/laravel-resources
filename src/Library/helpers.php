<?php

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use OwowAgency\LaravelResources\Resources\ResourceFactory;

if (! function_exists('resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  boolean  $isCollection|null
     * @return mixed
     */
    function resource($model, $isCollection = null)
    {
        if (is_null($isCollection)) {
            if (
                $model instanceof Collection
                || $model instanceof LengthAwarePaginator
            ) {
                $isCollection = true;
            } else {
                $isCollection = false;
            }
        }

        $resource = (new ResourceFactory)->make($model, $isCollection);

        if ($model instanceof LengthAwarePaginator) {
            $model->setCollection($resource->collection);

            return $model;
        }

        return $resource;
    }
}
