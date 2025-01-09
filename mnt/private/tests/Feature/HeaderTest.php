<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Session;


class HeaderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_header_for_role_eleve()
    {
        Session::start();
        Session::put('type_id', 1);

        $response = $this->get('/profile');

        $response->assertSee('Mes Séances');
        $response->assertSee('Mon bilan');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_eleve_dont_see_valider_niveau()
    {
        Session::start();
        Session::put('type_id', 1);

        $response = $this->get('/profile');

        $response->assertDontSee('Valider niveau');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_header_for_dt()
    {
        Session::put('type_id', 4);

        $response = $this->get('/profile');

        $response->assertSee('Créer une formation');
        $response->assertSee('Valider niveau');
        $response->assertSee('Modération');
        $response->assertSee('Personnaliser le site');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_header_for_initiateur()
    {
        Session::put('type_id', 2);

        $response = $this->get('/profile');

        $response->assertSee('Bilan des formations');
        $response->assertSee('Liste des élèves');
    }
}
