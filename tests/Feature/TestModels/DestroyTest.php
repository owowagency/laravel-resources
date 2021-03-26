<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class DestroyTest extends TestCase
{
    /** @test */
    public function can_destroy()
    {
        [$model] = $this->prepare();

        $response = $this->makeRequest($model);

        $this->assertResponse($response);

        $this->assertDatabase($model);
    }

    /** @test */
    public function cannot_destroy()
    {
        [$model] = $this->prepare();

        $this->mockPolicy('delete', false);

        $response = $this->makeRequest($model);

        $this->assertResponse($response, 403);
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
     * @param  \OwowAgency\LaravelResources\Tests\Support\Models\TestModel  $model
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeRequest(TestModel $model): TestResponse
    {
        return $this->delete("test-models/$model->id");
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
     * @param  int  $status
     * @return void
     */
    protected function assertResponse(TestResponse $response, int $status = 204): void
    {
        $response->assertStatus($status);
    }

    /**
     * Asserts the database.
     * 
     * @param  \OwowAgency\LaravelResources\Tests\Support\Models\TestModel  $model
     * @return void
     */
    protected function assertDatabase(TestModel $model): void
    {
        $this->assertDatabaseMissing('test_models', [
            'id' => $model->id,
        ]);
    }
}
