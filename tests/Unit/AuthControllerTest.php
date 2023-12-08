<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\College;
use Database\Factories\UserFactory;
use Database\Factories\CollegeFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginPost()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt($password = 'i-love-laravel'),
            'role_id' => 1,
            'verified' => true,
        ]);
    
        $requestData = [
            'email_or_student_number' => $user->email,
            'password' => $password,
        ];
    
        // Act
        $response = $this->post(route('login.post'), $requestData);
    
        // Assert
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function testRegisterPost()
    {
        // Arrange
        Storage::fake('google'); // Mock Google Drive storage

        $file = UploadedFile::fake()->image('avatar.jpg');

        // Create a college using a factory
        $college = College::factory()->create();

        $requestData = [
            'id' => $file,
            'firstname' => 'Test',
            'lastname' => 'User',
            'suffix' => 'Jr',
            'email' => 'testuser@lnu.edu.ph',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => '1',
            'year_level' => '1',
            'student_number' => '1234567',
            'college_id' => $college->id,
        ];

        // Act
        $response = $this->post(route('register.post'), $requestData);

        // Assert
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@lnu.edu.ph',
        ]);
    }

    public function testLogout()
    {
        // Arrange
        $user = User::factory()->create();

        // Act
        // Log in the user
        $this->be($user);

        // Send a GET request to the logout route
        $response = $this->get(route('logout'));

        // Assert
        // Assert that the user is no longer authenticated
        $this->assertGuest();

        // Assert that the response is a redirect to the login page
        $response->assertRedirect(route('login'));
    }
}
