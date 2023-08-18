<?php

namespace OwowAgency\LaravelResources\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\Controllers\ResourceController;
use OwowAgency\LaravelResources\LaravelResourcesServiceProvider;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Tests\Support\Requests\TestModelRequest;
use OwowAgency\Snapshots\MatchesSnapshots;

abstract class TestCase extends BaseTestCase
{
    use MatchesSnapshots;

    /**
     * Setup the test environment.
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
     */
    private function setUpDatabase(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    /**
     * Sets up the routes used for testing.
     */
    private function setUpRoutes(): void
    {
        Route::resource('test-models', ResourceController::class, [
            'model' => TestModel::class,
            'requests' => [
                'store' => TestModelRequest::class,
                'update' => TestModelRequest::class,
            ],
        ]);
    }
}
