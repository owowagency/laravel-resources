<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class IndexTest extends TestCase
{
    /** @test */
    public function can_index(): void
    {
        $this->prepare();

        $response = $this->makeRequest();

        $this->assertResponse($response);
    }

    /** @test */
    public function cannot_index(): void
    {
        $this->prepare();

        $this->mockPolicy('viewAny', false);

        $response = $this->makeRequest();

        $this->assertResponse($response, 403);
    }

    /**
     * Prepares for tests.
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
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get('test-models');
    }

    /**
     * Asserts a response.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse
     */
    protected function assertResponse(TestResponse $response, int $status = 200): void
    {
        $response->assertStatus($status);

        if ($status === 200) {
            $this->assertJsonStructureSnapshot($response);
        }
    }
}
