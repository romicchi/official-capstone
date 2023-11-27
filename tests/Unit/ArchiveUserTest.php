<?php

namespace Tests\Unit;

use App\Models\ArchiveUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArchiveUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_archive_user_can_be_created()
    {
        $archiveUser = ArchiveUser::factory()->create();

        $this->assertDatabaseHas('archive_users', ['id' => $archiveUser->id]);
    }
}