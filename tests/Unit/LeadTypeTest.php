<?php

namespace Tests\Unit;

use App\Models\LeadType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_lead_type(): void
    {
        $type = LeadType::factory()->create();

        $this->assertDatabaseHas('lead_types', ['id' => $type->id]);
    }

    public function test_name_is_translatable(): void
    {
        $type = LeadType::factory()->create();

        $this->assertTrue(in_array('name', $type->getTranslatableAttributes()));
    }
}
