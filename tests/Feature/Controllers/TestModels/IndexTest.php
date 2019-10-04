<?php

namespace OwowAgency\LaravelResources\Tests\Feature\Controllers\TestModels;

use OwowAgency\LaravelResources\Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function index_can_be_requested()
    {
        $response = $this->get('test-models');

        $response->json();

        $response->assertStatus(200);
    }
}
