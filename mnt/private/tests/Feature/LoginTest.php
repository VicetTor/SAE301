<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_connection_page()
    {
        $response = $this->get('/connexion');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_connection_is_succes_with_valid_login()
    {
        $response = $this->post('/login', [
            'email' => 'eleve1@secool.fr',
            'password' => 'Password123',
        ]);

        // Assert the login was successful and user is authenticated
        $response->assertRedirect('/home');
    }
}
