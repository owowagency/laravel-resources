<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Tests\Support\Snapshots\MatchesSnapshots;

class IndexTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function index_can_be_requested()
    {
        $this->prepare();

        $response = $this->makeRequest();

        $this->assertResponse($response);
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    protected function prepare(): array
    {
        $model = TestModel::create([
            'value' => 'some_value',
        ]);

        return [$model];
    }

    /**
     * Makes a request.
     * 
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get('test-models');
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $this->assertMatchesJsonSnapshot($response->json());
    }
}
