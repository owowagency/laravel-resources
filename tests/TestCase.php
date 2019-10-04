<?php

namespace OwowAgency\LaravelResources\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\LaravelResourcesServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelResourcesServiceProvider::class,
        ];
    }
}
