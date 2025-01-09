<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
     * Returns error 500 because user not logged in
     *
     * @return void
     */
    public function test_get_home_page_whitout_connexion_failure()
    {
        $response = $this->get('/');

        $response->assertStatus(500);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_connection_student_is_succes_with_valid_login()
    {
        $response = $this->post('/connexion', [
            'email' => 'eleve1@secool.fr',
            'password' => 'Password123',
        ]);

        $response->assertRedirect(route('students'));
        $this->assertEquals('eleve1@secool.fr', session('user_mail'));
        $response->assertStatus(302);
    }

    public function test_connection_dt_is_succes_with_valid_login()
    {
        $response = $this->post('/connexion', [
            'email' => 'dt3@secool.fr',
            'password' => 'Password123',
        ]);

        $response->assertRedirect(route('students'));
        $this->assertEquals('dt3@secool.fr', session('user_mail'));
        $response->assertStatus(302);
    }

    /**
     * Connection failure
     *
     * @return void
     */
    public function test_login_fails_when_wrong_password()
    {
        $response = $this->post('/connexion', [
            'email' => 'eleve1@secool.fr',
            'password' => 'password456',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('fail', 1);

        $this->assertNull(session('user_mail'), 'La session utilisateur ne doit pas être définie.');
    }



    /**
     * Connection failure
     *
     * @return void
     */
    public function test_attempt_connection_with_nonexistent_account_connection_failure()
    {
        $response = $this->post('/connexion', [
            'email' => 'louisa@secool.fr',
            'password' => 'whynot123',
        ]);

        $response->assertRedirect('/');
        $this->assertNull(session('user_mail'));
        $response->assertSessionHas('fail', 1);
    }

    /**
     * Connection failure
     *
     * @return void
     */
    public function test_login_fails_when_email_is_missing()
    {
        $response = $this->post('/connexion', [
            'password' => 'Password123',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Connection failure
     *
     * @return void
     */
    public function test_login_fails_when_password_is_missing()
    {
        $response = $this->post('/connexion', [
            'email' => 'eleve1@secool.fr',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Connection failure
     *
     * @return void
     */
    public function test_login_fails_with_invalid_email_format()
    {
        $response = $this->post('/connexion', [
            'email' => 'whynot',
            'password' => 'Password123',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Connection failure
     *
     * @return void
     */
    public function test_login_fails_when_password_is_too_short()
    {
        $response = $this->post('/connexion', [
            'email' => 'eleve1@secool.fr',
            'password' => '123',
        ]);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['password']);
    }
}
