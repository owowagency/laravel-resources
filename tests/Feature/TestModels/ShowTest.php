<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use Illuminate\Testing\TestResponse;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

class ShowTest extends TestCase
{
    /** @test */
    public function can_show()
    {
        [$model] = $this->prepare();

        $response = $this->makeRequest($model);

        $this->assertResponse($response);
    }

    /** @test */
    public function cannot_show()
    {
        [$model] = $this->prepare();

        $this->mockPolicy('view', false);

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
        return $this->get("test-models/$model->id");
    }

    /**
     * Asserts a response.
     * 
     * @param  \Illuminate\Foundation\Testing\TestResponse
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
}
