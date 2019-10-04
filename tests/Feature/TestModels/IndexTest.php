<?php

namespace OwowAgency\LaravelResources\Tests\Feature\TestModels;

use OwowAgency\LaravelResources\Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function migrate_you_fucking_cunt()
    {
        $response = $this->get('test-models');

        $response->assertStatus(200);
    }
}
