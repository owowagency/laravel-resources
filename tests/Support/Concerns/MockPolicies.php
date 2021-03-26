<?php

namespace OwowAgency\LaravelResources\Tests\Support\Concerns;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use OwowAgency\LaravelResources\Tests\Support\Models\TestModel;

trait MockPolicies
{
    /**
     * Mock the policies.
     *
     * @param  string  $ability
     * @param  bool  $result
     * @return void
     */
    public function mockPolicy(string $ability, bool $result = true): void
    {
        $gate = Gate::partialMock();

        $gate->shouldReceive('getPolicyFor')
            ->with(TestModel::class)
            ->andReturn($result);

        $gate->shouldReceive('resolveUser')
            ->andReturn(new User());

        $gate->shouldReceive('dispatchGateEvaluatedEvent');

        Gate::define($ability, fn () => $result);
    }
}
