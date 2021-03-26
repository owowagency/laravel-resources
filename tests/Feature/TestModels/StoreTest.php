<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;

class StoreTest extends TestCase
{
    /** @test */
    public function can_store(): void
    {
        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->assertResponse($response);

        $this->assertDatabase($data);
    }

    /** @test */
    public function cannot_store(): void
    {
        $this->mockPolicy('create', false);

        $data = $this->requestData();

        $response = $this->makeRequest($data);

        $this->assertResponse($response, 403);
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
        return $this->json('POST', 'test-models', $data);
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  int  $status
     * @return void
     */
    protected function assertResponse(TestResponse $response, int $status = 201): void
    {
        $response->assertStatus($status);

        if ($status === 201) {
            $this->assertJsonStructureSnapshot($response);
        }
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
