<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Tests\Support\Snapshots\MatchesSnapshots;

class StoreTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function index_can_be_requested()
    {
        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->assertResponse($response);

        $this->assertDatabase($data);
    }

    /**
     * Returns data that could be used in a request.
     * 
     * @return array
     */
    protected function requestData(): array
    {
        return [
            'value' => 'some_other_value',
        ];
    }

    /**
     * Makes a request.
     * 
     * @param  array  $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post('test-models', $data);
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $this->assertJsonStructureSnapshot($response);
    }

    /**
     * Asserts the database.
     * 
     * @param  array  $data
     * @return void
     */
    protected function assertDatabase(array $data): void
    {
        $this->assertDatabaseHas('test_models', $data);
    }
}
