<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_event(): void
    {
        $event = Event::factory()->create();

        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    public function test_event_belongs_to_teacher(): void
    {
        $event = Event::factory()->create();

        $this->assertInstanceOf(Teacher::class, $event->teacher);
    }
}
