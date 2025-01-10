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

        $response->assertStatus(200);
        $response->assertSee('Modification du profil');
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
        // Initialisation de la session
        Session::start();
        Session::put([
            'USER_ID' => 1,
            'USER_MAIL' => 'eleve1@secool.fr',
            'USER_PHONENUMBER' => '0623456789',
            'USER_ADDRESS' => '10 rue de la Plongée, Paris',
            'USER_POSTALCODE' => '75001',
        ]);

    
        // Requête POST pour mettre à jour les informations utilisateur
        $response = $this->post(route('infoUserUpdate'), [
            '_token' => csrf_token(),
            'inputEmail' => 'nouveau.email@secool.fr',
            'inputPhoneNumber' => '0612345678',
            'inputAddress' => '20 rue Nouvelle, Lyon',
            'inputPostalCode' => '69001',
        ]);
    
        // Vérifier la redirection vers le profil
       //$response->assertRedirect(route('profile'));
    
        // Vérifier que les données dans la base sont mises à jour
        $this->assertDatabaseHas('grp2_user', [
            'USER_ID' => 1,
            'USER_MAIL' => 'nouveau.email@secool.fr',
            'USER_PHONENUMBER' => '0612345678',
            'USER_ADDRESS' => '20 rue Nouvelle, Lyon',
            'USER_POSTALCODE' => '69001',
        ]);
    
        // Vérifier les données dans la session
        $this->assertEquals('nouveau.email@secool.fr', Session::get('user_mail'));
        $this->assertEquals('0612345678', Session::get('user_phonenumber'));

    }

    // /**
    //  * Test : Mise à jour du mot de passe avec succès.
    //  */
    // public function test_user_password_update_success()
    // {
    //     // Simuler une session utilisateur
    //     Session::start();
    //     Session::put(['user_id' => 1]);

    //     // Effectuer une requête POST pour modifier le mot de passe
    //     $response = $this->post(route('pswdUserUpdate'), [
    //         '_token' => csrf_token(),
    //         'inputActualPassword' => 'Password123', // Mot de passe actuel
    //         'inputNewPassword' => 'NewPass123!',
    //         'inputPasswordVerif' => 'NewPass123!',
    //     ]);

    //     // Vérifier la redirection après succès
    //     $response->assertRedirect(route('profile'));

    //     // Vérifier si le mot de passe a bien été mis à jour
    //     $this->assertTrue(
    //         Hash::check('NewPass123!', User::find(1)->USER_PASSWORD)
    //     );
    // }

    // /**
    //  * Test : Gestion des erreurs de validation.
    //  */
    // public function test_user_update_validation_error()
    // {
    //     // Simuler une session utilisateur
    //     Session::start();
    //     Session::put(['user_id' => 1]);

    //     // Effectuer une requête POST avec des données invalides
    //     $response = $this->post(route('infoUserUpdate'), [
    //         '_token' => csrf_token(),
    //         'inputEmail' => 'email_invalide',
    //         'inputPhoneNumber' => '123', // Numéro de téléphone invalide
    //         'inputAddress' => '',
    //         'inputPostalCode' => '',
    //     ]);

    //     // Vérifier si des messages d'erreur s'affichent
    //     $response->assertSessionHasErrors([
    //         'inputEmail',
    //         'inputPhoneNumber',
    //         'inputAddress',
    //         'inputPostalCode',
    //     ]);
    // }
}
