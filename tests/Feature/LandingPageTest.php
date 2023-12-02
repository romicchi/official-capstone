<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_landing_page_loads_correctly()
    {
        // Send a GET request to the route named 'landing'
        $response = $this->get('/');

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the view has certain text
        $response->assertSeeText('Welcome');
        $response->assertSeeText('About');
        $response->assertSeeText('Features');
        $response->assertSeeText('Talk to GENER');
    }

    public function test_login_route_works()
    {
        $response = $this->get('/login');
    
        $response->assertStatus(200);
    }

    public function test_register_route_works()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }
}