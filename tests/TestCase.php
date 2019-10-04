<?php

namespace OwowAgency\LaravelResources\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OwowAgency\LaravelResources\LaravelResourcesServiceProvider;

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

        require __DIR__ . '/support/routes/test-models.php';
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
}
