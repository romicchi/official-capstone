<?php

namespace Tests\Unit;

use App\Models\Discipline;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_discipline_has_many_resources()
    {
        $discipline = Discipline::factory()->create();
        $resource1 = Resource::factory()->create(['discipline_id' => $discipline->id]);
        $resource2 = Resource::factory()->create(['discipline_id' => $discipline->id]);

        $this->assertTrue($discipline->resources->contains($resource1));
        $this->assertTrue($discipline->resources->contains($resource2));
    }
}