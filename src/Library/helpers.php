<?php

use OwowAgency\LaravelResources\Resources\ResourceFactory;

if (! function_exists('resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  mixed  $model
     * @param  boolean  $isPlural
     * @return mixed
     */
    function resource($model, $isPlural = null)
    {
        return (new ResourceFactory)->make($model, $isPlural);
    }
}
