<?php

use OwowAgency\LaravelResources\Resources\ResourceFactory;

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
        return (new ResourceFactory)->make($model, $isCollection);
    }
}
