<?php

namespace OwowAgency\LaravelResources\Tests\Support\Snapshots;

use Illuminate\Foundation\Testing\TestResponse;
use Spatie\Snapshots\MatchesSnapshots as BaseMatchesSnapshots;
use OwowAgency\LaravelResources\Tests\Support\Snapshots\Drivers\JsonStructureDriver;

trait MatchesSnapshots
{
    use BaseMatchesSnapshots;

    /**
     * Asserts the structure of the response json with a snapshot.
     *
     * @param  \Illuminate\Foundation\Testing\TestResponse  $response
     * @return void
     */
    public function assertJsonStructureSnapshot(TestResponse $response): void
    {
        $this->assertMatchesSnapshot(
            $response->json(),
            new JsonStructureDriver()
        );
    }
}
