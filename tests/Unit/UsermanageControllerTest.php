<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\Factories\UserFactory;
use Tests\Factories\JournalFactory;
use Tests\Factories\CollegeFactory;
use Tests\Factories\DisciplineFactory;
use App\Http\Controllers\UsermanageController;
use Tests\TestCase;
use App\Models\College;
use App\Models\User;
use App\Models\Journal;
use App\Mail\UserVerifiedEmail;

class UsermanageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAddUser()
    {
        // Arrange
        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $admin = User::factory()->create(); // Assume this is an admin user
        $this->actingAs($admin);
        $college = College::factory()->create();

    
        $userData = [
            'id' => $file,
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 1,
            'year_level' => 1,
            'student_number' => '1234567',
            'college_id' => $college->id,
        ];
    
        // Act
        $response = $this->post(route('add.user'), $userData);
    
        // Assert
        $response->assertRedirect(route('usermanage', ['activeTab' => 'existing']));
        $response->assertSessionHas('success', 'User created successfully.');
    
        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'testuser@example.com',
            'role_id' => 1,
            'year_level' => 1,
            'student_number' => '1234567',
            'college_id' => $college->id,
        ]);
    }

    public function testPostVerifyUsers()
    {
        // Arrange
        $admin = User::factory()->create(); // Assume this is an admin user
        $this->actingAs($admin);
        $verifiedUsers = User::factory()->count(3)->create();
        $rejectedUsers = User::factory()->count(2)->create();
    
        $verifiedUserIds = $verifiedUsers->pluck('id')->toArray();
        $rejectedUserIds = $rejectedUsers->pluck('id')->toArray();
    
        $requestData = [
            'verified_users' => $verifiedUserIds,
            'rejected_users' => $rejectedUserIds,
        ];
    
        // Act
        $response = $this->post(route('verify-users.post'), $requestData);
    
        // Assert
        $response->assertRedirect(route('usermanage', ['activeTab' => 'pending']));
        $response->assertSessionHas('success', 'Users verified successfully.');
    
        foreach ($verifiedUsers as $user) {
            $this->assertDatabaseHas('users', [
                'id' => $user->id,
                'verified' => true,
            ]);
        }
    
        foreach ($rejectedUsers as $user) {
            $this->assertDatabaseMissing('users', ['id' => $user->id]);
        }
    }

    public function testdelete()
    {
        // Arrange
        $admin = User::factory()->create(); // Assume this is an admin user
        $this->actingAs($admin);
    
        $userToDelete = User::factory()->create();
        $journals = Journal::factory()->count(3)->create(['user_id' => $userToDelete->id]);
    
        // Act
        $response = $this->get(route('delete', ['id' => $userToDelete->id]));
    
        // Assert
        $response->assertSessionHas('success', 'User deleted successfully.');
    
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    
        foreach ($journals as $journal) {
            $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
        }
    }


}
