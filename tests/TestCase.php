<?php

namespace OwowAgency\LaravelResources\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\LaravelResourcesServiceProvider;
use OwowAgency\LaravelResources\Controllers\ResourceController;


class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(
            __DIR__ . '/support/database/migrations'
        );

        $this->setUpRoutes();
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelResourcesServiceProvider::class,
        ];
    }

    /**
     * Create the test response instance from the given response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return \Tests\TestResponse
     */
    protected function createTestResponse($response)
    {
        return TestResponse::fromBaseResponse($response);
    }

    /**
     * Sets up the routes that are used during testing.
     * 
     * @return void
     */
    private function setUpRoutes(): void
    {
        Route::resource('test-models', ResourceController::class, [
            'only' => [
                'index',
            ],
            'model' => TestModel::class,
            // 'requests' => [
            //     'store' => StoreRequest::class,
            //     'update' => UpdateRequest::class,
            // ],
        ]);
    }
}
