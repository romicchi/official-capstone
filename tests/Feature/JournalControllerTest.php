<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Journal;
use App\Models\Discipline;
use App\Models\College;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_method_returns_correct_view_with_data()
    {
        // Arrange
        $user = User::factory()->create();
        $discipline = Discipline::factory()->create();
        $journals = Journal::factory()->count(5)->create([
            'user_id' => $user->id,
            'discipline_id' => $discipline->id
        ]);

        // Act
        $response = $this->actingAs($user)->get('/journals');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('journals.index');
        $response->assertViewHas('journals');
        $response->assertViewHas('disciplines');
    }

    public function test_store_method_creates_new_journal_and_redirects()
    {
        // Arrange
        $user = User::factory()->create();
        $college = College::factory()->create();
        $discipline = Discipline::factory()->create();
        $journalData = [
            'title' => 'Test Journal',
            'content' => 'Test content',
            'college_id' => $college->id,
            'discipline_id' => $discipline->id,
        ];

        // Act
        $response = $this->actingAs($user)->post('/journals', $journalData);

        // Assert
        $response->assertRedirect(route('journals.show', Journal::first()));
        $this->assertDatabaseHas('journals', $journalData);
    }

    public function test_show_method_displays_correct_journal()
    {
        // Arrange
        $user = User::factory()->create();
        $journal = Journal::factory()->create(['user_id' => $user->id]);

        // Act
        $response = $this->actingAs($user)->get('/journals/' . $journal->id);

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('journals.show');
        $response->assertViewHas('journal', $journal);
    }

    public function test_update_method_updates_journal_and_redirects()
    {
        // Arrange
        $user = User::factory()->create();
        $journal = Journal::factory()->create(['user_id' => $user->id]);
        $updatedData = ['title' => 'Updated Title', 'content' => 'Updated Content'];

        // Act
        $response = $this->actingAs($user)->put('/journals/' . $journal->id, $updatedData);

        // Assert
        $response->assertRedirect(route('journals.show', $journal));
        $this->assertDatabaseHas('journals', $updatedData);
    }

    public function test_destroy_method_deletes_journal_and_redirects()
    {
        // Arrange
        $user = User::factory()->create();
        $journal = Journal::factory()->create(['user_id' => $user->id]);
    
        // Act
        $response = $this->actingAs($user)->delete('/journals/' . $journal->id);
    
        // Assert
        $response->assertRedirect(route('journals.index'));
        $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
    }
    
    public function test_downloadPdf_method_returns_pdf_response()
    {
        // Arrange
        $user = User::factory()->create();
        $journal = Journal::factory()->create(['user_id' => $user->id]);
    
        // Act
        $response = $this->actingAs($user)->get('/journals/' . $journal->id . '/download-pdf');
    
        // Assert
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}