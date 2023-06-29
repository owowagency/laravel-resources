<?php

namespace OwowAgency\LaravelResources\Tests\Support\Models;

class TestModelRouteKey extends TestModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'test_models';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'value';
    }
}
