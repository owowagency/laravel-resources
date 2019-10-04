<?php

namespace OwowAgency\LaravelResources\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\Controllers\ResourceController;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
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

        $this->setUpDatabase();

        $this->setUpRoutes();
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

    /**
     * Sets up the database.
     * 
     * @return void
     */
    private function setUpDatabase(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Sets up the routes used for testing.
     * 
     * @return void
     */
    private function setUpRoutes(): void
    {
        Route::resource('test-models', ResourceController::class, [
            'model' => TestModel::class,
        ]);
    }
}
