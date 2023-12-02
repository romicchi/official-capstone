<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_displays_validation_errors()
    {
        $response = $this->post(route('login.post'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email_or_student_number');
        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function login_authenticates_and_redirects_user()
    {
        $response = $this->post(route('login.post'), [
            'email_or_student_number' => 'student@lnu.edu.ph',
            'password' => 'test12345',
        ]);
    
        $response->assertRedirect(route('login'));
    }
}