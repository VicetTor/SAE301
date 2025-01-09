<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeDataTest extends TestCase
{
    use RefreshDatabase;


    // /**
    //  * A basic test example.
    //  *
    //  * @return void
    //  */
    // public function test_correct_name_club_on_home_page()
    // {

    //     DB::shouldReceive('first')
    //         ->andReturn((object) ['CLUB_NAME' => 'Club de Plongée Test']);

    //     $response = $this->call('GET', '/');
    //     if ($response->status() !== 200) {
    //         $response->dumpHeaders();
    //         $response->dump();
    //     }

    //     $this->assertEquals(200, $response->status());
    // }
}
