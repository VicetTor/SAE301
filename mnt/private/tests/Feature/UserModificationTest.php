<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserModificationTest extends TestCase
{


    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_modification_page_loads_correctly_with_user_informations()
    {
        Session::start();
        Session::put([
            'user_mail' => 'eleve1@secool.fr',
            'user_phonenumber' => '0623456789',
            'user_address' => '10 rue de la Plongée, Paris',
            'user_postalcode' => '75001',
        ]);

        $response = $this->get('/user');

        $response->assertSee('eleve1@secool.fr'); // Email de l'utilisateur
        $response->assertSee('0623456789'); // Téléphone
        $response->assertSee('10 rue de la Plongée, Paris'); // Adresse
        $response->assertSee('75001'); // Code postal
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_info_update_success()
    {
        Session::start();
        Session::put([
            'USER_ID' => 1,
            'USER_MAIL' => 'eleve1@secool.fr',
            'USER_PHONENUMBER' => '0623456789',
            'USER_ADDRESS' => '10 rue de la Plongée, Paris',
            'USER_POSTALCODE' => '75001',
        ]);

    
        $response = $this->post(route('infoUserUpdate'), [
            '_token' => csrf_token(),
            'inputEmail' => 'nouveau.email@secool.fr',
            'inputPhoneNumber' => '0612345678',
            'inputAddress' => '20 rue Nouvelle, Lyon',
            'inputPostalCode' => '69001',
        ]);
    

        $this->assertDatabaseHas('grp2_user', [
            'USER_ID' => 1,
            'USER_MAIL' => 'test@secool.fr',
            'USER_PHONENUMBER' => '0612345678',
            'USER_ADDRESS' => '20 rue Nouvelle, Lyon',
            'USER_POSTALCODE' => '69001',
        ]);
    
        $this->assertEquals('test@secool.fr', Session::get('user_mail'));
        $this->assertEquals('0612345678', Session::get('user_phonenumber'));

    }
}
