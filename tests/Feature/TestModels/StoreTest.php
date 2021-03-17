<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;

class StoreTest extends TestCase
{
    /** @test */
    public function store_can_be_requested()
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
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post('test-models', $data);
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $response->assertStatus(201);

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
