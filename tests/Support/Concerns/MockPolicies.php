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
     * @param  bool  $success
     * @return void
     */
    public function mockPolicy(bool $success): void
    {
        $gate = Gate::partialMock();

        $gate->shouldReceive('getPolicyFor')
            ->with(TestModel::class)
            ->andReturn(true);

        $gate->shouldReceive('resolveUser')
            ->andReturn(new User());

        $gate->shouldReceive('dispatchGateEvaluatedEvent');

        Gate::define(
            'create',
            function (User $user, $target) use ($success) {
                return false;
            },
        );
    }
}
