<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TestLoginController extends TestCase
{
    use RefreshDatabase;

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
    
    /**
     * 
     *
     * @return void
     */
    public function test_login_page_is_accessible()
    {
        $response = $this->get(route('connexion'));

        $response->assertStatus(200);
        $response->assertSee('CONNEXION');
    }

    /**
     * 
     *
     * @return void
     */
    public function test_successful_login_with_valid_user()
    {
        // Crée un utilisateur pour les tests
        $user = User::factory()->create([
            'USER_MAIL' => 'eleve1@secool.fr',
            'USER_PASSWORD' => Hash::make('Password123')
        ]);

        $response = $this->post(route('connexion'), [
            'email' => 'eleve1@secool.fr',
            'password' => 'Password123'
        ]);

        $response->assertRedirect(route('students'));

        $this->assertEquals(session('user_mail'), 'eleve1@secool.fr');
        $this->assertEquals(session('user_firstname'), $user->USER_FIRSTNAME);
    }

    /**
     * 
     *
     * @return void
     */
    public function test_failed_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'USER_MAIL' => 'eleve1@secool.fr',
            'USER_PASSWORD' => Hash::make('badPassword1')
        ]);

        $response = $this->post(route('connexion'), [
            'email' => 'eleve1@secool.fr',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHas('fail', 1);
        $response->assertRedirect(route('connexion'));
    }

    /**
     *
     *
     * @return void
     */
    public function test_login_validation()
    {
        // Test sans email
        $response = $this->post(route('connexion'), [
            'email' => '',
            'password' => 'Password123'
        ]);

        $response->assertSessionHasErrors('email');

        // Test sans mot de passe
        $response = $this->post(route('connexion'), [
            'email' => 'eleve1@secool.fr',
            'password' => ''
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * 
     *
     * @return void
     */
    public function test_redirect_to_first_connection_page_if_first_login()
    {
        // Crée un utilisateur avec le flag USER_ISFIRSTLOGIN à 1
        $user = User::factory()->create([
            'USER_MAIL' => 'firstlogin@example.com',
            'USER_PASSWORD' => Hash::make('password123'),
            'USER_ISFIRSTLOGIN' => 1
        ]);

        $response = $this->post(route('connexion'), [
            'email' => 'firstlogin@example.com',
            'password' => 'password123'
        ]);

        // Vérifie que l'utilisateur est redirigé vers la page de première connexion
        $response->assertRedirect(route('firstconnexion'));
    }
}
