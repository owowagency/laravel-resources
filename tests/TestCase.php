<?php

namespace OwowAgency\LaravelResources\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\LaravelResourcesServiceProvider;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelResourcesServiceProvider::class,
        ];
    }
}
