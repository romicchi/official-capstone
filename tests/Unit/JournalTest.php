<?php

namespace Tests\Unit;

use App\Models\Journal;
use App\Models\User;
use App\Models\Discipline;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_journal_belongs_to_a_user_and_a_discipline()
    {
        $user = User::factory()->create();
        $discipline = Discipline::factory()->create();
        $journal = Journal::factory()->create(['user_id' => $user->id, 'discipline_id' => $discipline->id]);

        $this->assertEquals($user->id, $journal->user->id);
        $this->assertEquals($discipline->id, $journal->discipline->id);
    }
}