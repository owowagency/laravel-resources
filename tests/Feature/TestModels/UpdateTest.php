<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class UpdateTest extends TestCase
{
    /** @test */
    public function can_update()
    {
        [$model] = $this->prepare();

        $data = $this->requestData();

        $response = $this->makeRequest($model, $data);

        $this->assertResponse($response);

        $this->assertDatabase($model, $data);
    }

    /** @test */
    public function cannot_update()
    {
        [$model] = $this->prepare();

        $this->mockPolicy('update', false);

        $data = $this->requestData();

        $response = $this->makeRequest($model, $data);

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
     * @param  array  $data
     * @return \Illuminate\Testing\TestResponse
     */
    protected function makeRequest(TestModel $model, array $data): TestResponse
    {
        return $this->put("test-models/$model->id", $data);
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  int  $status
     * @return void
     */
    protected function assertResponse(TestResponse $response, int $status = 200): void
    {
        $response->assertStatus($status);

        if ($status === 200) {
            $this->assertJsonStructureSnapshot($response);
        }
    }

    /**
     * Asserts the database.
     * 
     * @param  \OwowAgency\LaravelResources\Tests\Support\Models\TestModel  $model
     * @param  array  $data
     * @return void
     */
    protected function assertDatabase(TestModel $model, array $data): void
    {
        $this->assertDatabaseHas('test_models', array_merge(
            ['id' => $model->id],
            $data
        ));
    }
}
