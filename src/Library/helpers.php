<?php

use OwowAgency\LaravelResources\Resources\ResourceFactory;

if (! function_exists('resource')) {
    /**
     * Makes the resource for the specified model class.
     *
     * @param  bool  $isPlural
     */
    function resource($model, $isPlural = null)
    {
        return (new ResourceFactory)->make($model, $isPlural);
    }
}
