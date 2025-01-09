<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ProfileTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_modifying_information_redirection()
    {
        $response = $this->get('/profile');

        $response->assertSee('Modifier mes informations');
        $response->assertSee('/user');

        $response = $this->get('/user');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_see_popup_for_account_suppression()
    {
        $response = $this->get('/profile');

        $response->assertSee('Supprimer mon compte');
        $response->assertSee('popupDeletion');
        $response->assertSee('Adresse Mail:');
        $response->assertSee('Numéro de téléphone:');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_is_logout()
    {
        Session::start();
        Session::put('user_id', 1);

        $response = $this->get('/profile');
        $response->assertSee('Se déconnecter');
        $response->assertSee('/logOut');

        $response = $this->get('/logOut');

        $response->assertRedirect('/connexion');

        $this->assertFalse(Session::has('user_id'), 'User_id non null');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_see_their_data()
    {
        // Simuler une session utilisateur
        Session::start();
        Session::put([
            'user_firstname' => 'Louisa',
            'user_lastname' => 'M',
            'user_birthdate' => '2005-03-03',
            'user_address' => '1 rue par la',
            'user_postalcode' => '14123',
            'user_mail' => 'Louisa@secool.fr',
            'user_phonenumber' => '0000000000',
            'user_licensenumber' => 'A-00-000000',
            'level_id' => '0'
        ]);

        $response = $this->get('/profile');

        $response->assertSee('Louisa');
        $response->assertSee('M');
        $response->assertSee('2005-03-03');
        $response->assertSee('1 rue par la');
        $response->assertSee('14123');
        $response->assertSee('Louisa@secool.fr');
        $response->assertSee('0000000000');
        $response->assertSee('A-00-000000');
        $response->assertSee('0');
    }
}
