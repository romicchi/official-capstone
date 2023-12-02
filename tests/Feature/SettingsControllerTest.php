<?php

namespace Tests\Unit;

use App\Http\Controllers\SettingsController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateProfile()
    {
        $user = User::factory()->create();

        $request = new Request([
            'firstname' => 'NewFirstName',
            'lastname' => 'NewLastName',
        ]);

        $this->actingAs($user);

        $controller = new SettingsController();

        $response = $controller->updateProfile($request);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'firstname' => 'NewFirstName',
            'lastname' => 'NewLastName',
        ]);
    }
}