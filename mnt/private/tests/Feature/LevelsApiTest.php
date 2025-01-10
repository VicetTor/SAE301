<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseTest extends TestCase
{

        /**
     * A basic test example.
     *
     * @return void
     */
    public function test_success()
    {
        $response = $this->get('/api/levels');
        $response->assertStatus(200);
    }

    public function test_get7()
    {
        $response = $this->get('/api/levels');
        $response->assertJsonCount(7);
    }

    public function test_get0Ok()
    {
        $response = $this->get('/api/levels');
        $this->assertTrue($response[0]['LEVEL_ID'] == 0);
    }

}
