<?php

namespace Tests\Unit;

use App\Models\Config;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfigTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_config(): void
    {
        $config = Config::factory()->create();

        $this->assertDatabaseHas('config', ['id' => $config->id]);
    }
}
