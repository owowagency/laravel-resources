<?php

namespace OwowAgency\LaravelResources\Tests\Unit\Http\Controllers\ResourceController;

use OwowAgency\LaravelResources\Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use OwowAgency\LaravelResources\Controllers\ResourceController;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModelRouteKey;

class GetModeltest extends TestCase
{
    /** @test */
    public function get_model_by_model_instance(): void
    {
        [$controller, $model] = $this->prepare();

        $result = $controller->getModel($model);

        $this->assertEquals($model, $result);
    }

    /** @test */
    public function get_model_by_id(): void
    {
        [$controller, $model] = $this->prepare();

        // Resource model class need to be set in order for the controller
        // which model to query.
        $controller->resourceModelClass = TestModel::class;

        // Get model by id.
        $result = $controller->getModel($model->id);

        $this->assertEquals($model->id, $result->id);
    }

    /**
     * It should not matter what key is used as long as it is tested that
     * something else than id can be used.
     * 
     * @test
     */
    public function get_model_by_value(): void
    {
        [$controller, $model] = $this->prepare();

        // Resource model class need to be set in order for the controller
        // which model to query. Set the same model but with a different
        // route key name.
        $controller->resourceModelClass = TestModelRouteKey::class;

        // Get model by value.
        $result = $controller->getModel($model->value);

        $this->assertEquals($model->id, $result->id);
    }

    /** @test */
    public function get_model_not_found(): void
    {
        [$controller, $model] = $this->prepare();

        // Resource model class need to be set in order for the controller
        // which model to query.
        $controller->resourceModelClass = TestModel::class;

        // Ecpect exception to be thrown.
        $this->expectException(ModelNotFoundException::class);

        // Get model unknown id.
        $controller->getModel(0);
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    protected function prepare(): array
    {
        $controller = new ResourceController();

        $model = TestModel::create([
            'value' => 'some_value',
        ]);

        return [$controller, $model];
    }
}
