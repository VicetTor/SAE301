<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseTest extends TestCase
{

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

    // public function test_successful_login_with_valid_user()
    // {
    //     $user = User::factory()->create([
    //         'USER_MAIL' => 'eleve1@secool.fr',
    //         'USER_PASSWORD' => Hash::make('Password123')
    //     ]);

    //     $response = $this->post(route('connexion'), [
    //         'email' => 'eleve1@secool.fr',
    //         'password' => 'Password123'
    //     ]);

    //     $response->assertRedirect(route('students'));
    //     $this->assertEquals(session('USER_MAIL'), 'eleve1@secool.fr');
    // }

    // public function test_failed_login_with_invalid_password()
    // {
    //     $user = User::factory()->create([
    //         'USER_MAIL' => 'eleve1@secool.fr',
    //         'USER_PASSWORD' => Hash::make('badPassword1')
    //     ]);

    //     $response = $this->post(route('connexion'), [
    //         'email' => 'eleve1@secool.fr',
    //         'password' => 'wrongpassword'
    //     ]);

    //     $response->assertSessionHas('fail', 1);
    // }

    // public function test_login_validation()
    // {
    //     $response = $this->post(route('connexion'), [
    //         'email' => '',
    //         'password' => 'Password123'
    //     ]);
    //     $response->assertSessionHasErrors('email');

    //     $response = $this->post(route('connexion'), [
    //         'email' => 'eleve1@secool.fr',
    //         'password' => ''
    //     ]);
    //     $response->assertSessionHasErrors('password');
    // }

    // public function test_club_name_displayed_for_logged_in_user()
    // {
    //     // Création d'un utilisateur avec un club spécifique
    //     $user = User::factory()->create([
    //         'USER_MAIL' => 'eleve1@secool.fr',
    //         'USER_PASSWORD' => bcrypt('password123'),
    //         'user_id' => 1 // ID utilisateur fictif
    //     ]);

    //     // Connexion simulée
    //     $this->actingAs($user);

    //     // Simuler la réponse de la requête DB
    //     DB::shouldReceive('table')
    //         ->once()
    //         ->with('REPORT')
    //         ->andReturnSelf()
    //         ->shouldReceive('select')
    //         ->once()
    //         ->with('CLUB_NAME')
    //         ->andReturnSelf()
    //         ->shouldReceive('join')
    //         ->once()
    //         ->with('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
    //         ->andReturnSelf()
    //         ->shouldReceive('where')
    //         ->once()
    //         ->with('user_id', '=', $user->id)
    //         ->andReturnSelf()
    //         ->shouldReceive('first')
    //         ->once()
    //         ->andReturn((object) ['CLUB_NAME' => 'ClubPlongee']);

    //     // Envoi de la requête pour afficher la page
    //     $response = $this->get('/');

    //     // Vérifier que le nom du club est bien affiché
    //     $response->assertSee('Bienvenue sur <strong>ClubPlongee</strong>', false);
    // }

    // public function test_modification_button_visibility_for_non_admin_user()
    // {
    //     // Création d'un utilisateur sans droits administratifs
    //     $user = User::factory()->create([
    //         'USER_MAIL' => 'eleve1@secool.fr',
    //         'USER_PASSWORD' => bcrypt('password123'),
    //         'type_id' => 2, // Utilisateur sans droits admin
    //     ]);

    //     // Connexion simulée
    //     $this->actingAs($user);

    //     // Envoi de la requête pour la page d'accueil
    //     $response = $this->get('/');

    //     // Vérifier que le bouton "Modération" n'est pas présent
    //     $response->assertDontSee('Modération');
    // }

    // public function test_modification_button_visibility_for_admin_user()
    // {
    //     // Création d'un utilisateur avec droits administratifs
    //     $admin = User::factory()->create([
    //         'USER_MAIL' => 'admin@secool.fr',
    //         'USER_PASSWORD' => bcrypt('adminpassword'),
    //         'type_id' => 4, // Administrateur
    //     ]);

    //     // Connexion simulée
    //     $this->actingAs($admin);

    //     // Envoi de la requête pour la page d'accueil
    //     $response = $this->get('/');

    //     // Vérifier que le bouton "Modération" est présent
    //     $response->assertSee('Modération');
    // }

    // public function test_redirect_to_home_after_login()
    // {
    //     $user = User::factory()->create([
    //         'USER_MAIL' => 'eleve1@secool.fr',
    //         'USER_PASSWORD' => bcrypt('password123'),
    //     ]);

    //     // Connexion simulée
    //     $this->actingAs($user);

    //     // Envoi de la requête pour la page d'accueil
    //     $response = $this->get('/');

    //     // Vérifier que la page d'accueil est bien affichée
    //     $response->assertStatus(200);
    // }
}
