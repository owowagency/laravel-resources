<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class DestroyTest extends TestCase
{
    /** @test */
    public function destroy_can_be_requested()
    {
        [$model] = $this->prepare();

        $response = $this->makeRequest($model);

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
     * @param  \OwowAgency\LaravelResources\Tests\Support\Models\TestModel  $model
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(TestModel $model): TestResponse
    {
        return $this->delete("test-models/$model->id");
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $response->assertStatus(204);
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
