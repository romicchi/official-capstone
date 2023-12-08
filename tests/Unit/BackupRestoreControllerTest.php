<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Tests\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\College;
use Database\Factories\CollegeFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class BackupRestoreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@lnu.edu.ph',
            'password' => Hash::make($password = 'i-love-laravel'),
            'role_id' => 4,
        ]);

        // Act as the superadmin user
        $this->actingAs($user);
    
        $requestData = [
            'email' => $user->email,
            'password' => $password,
        ];
    
        // Act
        $response = $this->post(route('administrator.login.submit'), $requestData);
    
        // Assert
        $response->assertRedirect(route('administrator.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function testBackup()
    {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@lnu.edu.ph',
            'password' => Hash::make($password = 'i-love-laravel'),
            'role_id' => 4,
        ]);

        // Act as the superadmin user
        $this->actingAs($user);

        // Act
        $response = $this->post(route('administrator.backup'));

        // Assert
        $response->assertRedirect(route('administrator.dashboard'));
        $response->assertSessionHas('success', 'Backup completed successfully.');
    }

    public function testRestore()
    {
        // Disable all middleware for this test
        $this->withoutMiddleware();
    
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@lnu.edu.ph',
            'password' => Hash::make($password = 'i-love-laravel'),
            'role_id' => 4,
        ]);
    
        // Act as the superadmin user
        $this->actingAs($user);
    
        // Create a mock backup file with some valid SQL content
        $backupFile = UploadedFile::fake()->createWithContent('backup.sql', 'SELECT 1;');
    
        $requestData = [
            'backup_file' => $backupFile,
        ];
    
    // Act
    $response = $this->from(route('administrator.dashboard'))
                     ->post(route('administrator.restore'), $requestData);

    // Assert
    $response->assertRedirect(route('administrator.dashboard'));
        $response->assertSessionHas('success', 'Database has been restored successfully!');
    }
}
