<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\TestCase;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Tests\Support\Snapshots\MatchesSnapshots;

class UpdateTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function update_can_be_requested()
    {
        [$model] = $this->prepare();

        $data = $this->requestData();

        $response = $this->makeRequest($model, $data);

        $this->assertResponse($response);
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
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(TestModel $model, array $data): TestResponse
    {
        return $this->put("test-models/$model->id", $data);
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
     * @return void
     */
    protected function assertResponse(TestResponse $response): void
    {
        $response->assertStatus(200);

        $this->assertJsonStructureSnapshot($response);
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
