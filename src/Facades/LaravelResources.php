<?php

namespace owowagency\LaravelResources\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelResources extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelresources';
    }
}
