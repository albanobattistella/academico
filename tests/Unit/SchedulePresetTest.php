<?php

namespace Tests\Unit;

use App\Models\SchedulePreset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchedulePresetTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_schedule_preset(): void
    {
        $preset = SchedulePreset::factory()->create();

        $this->assertDatabaseHas('schedule_presets', ['id' => $preset->id]);
    }
}
