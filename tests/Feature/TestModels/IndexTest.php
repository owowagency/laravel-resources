<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class IndexTest extends TestCase
{
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
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get('test-models');
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $response->assertStatus(200);

        $this->assertJsonStructureSnapshot($response->getContent());
    }
}
