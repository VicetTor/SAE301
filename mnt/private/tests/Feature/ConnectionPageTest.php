<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConnectionPageTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_connection_valid_user_and_return_home_page()
    {
        $response = $this->get('/connexion');

        $response->assertStatus(200);
    }
}
