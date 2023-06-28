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
     */
    protected function requestData(): array
    {
        return [
            'value' => 'some_other_value',
        ];
    }

    /**
     * Makes a request.
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->json('POST', 'test-models', $data);
    }

    /**
     * Asserts a response.
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
     */
    protected function assertDatabase(array $data): void
    {
        $this->assertDatabaseHas('test_models', $data);
    }
}
