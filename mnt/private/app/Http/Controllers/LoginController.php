<?php

namespace App\Http\Controllers;

use App\Models\User; // Importing the User model
use Illuminate\Http\Request; // Importing the Request class for handling HTTP requests
use Illuminate\Support\Facades\DB; // Importing the DB facade for database interactions
use Illuminate\Support\Facades\Hash; // Importing Hash for password hashing
use Illuminate\Support\Facades\Session; // Importing Session for session management

class LoginController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/login",
     *     summary="Displays the login page",
     *     tags={"Login"},
     *     @OA\Response(
     *         response=200,
     *         description="Login page displayed successfully"
     *     )
     * )
     */
    function create()
    {
        // Return the view for the login page.
        return view('ConnexionPage');
    }

    /**
     * Attempts to authenticate the user with the provided email and password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    function tryConnect(Request $request)
    {
        // Validate the incoming request to ensure required fields are present and valid.
        $request->validate([
            'email' => 'required|email', // Email must be valid.
            'password' => 'required|min:6', // Password must have a minimum length of 6 characters.
        ]);

        // Retrieve email and password from the request input.
        $mail = $request->input('email');
        $password = $request->input('password');

        // Query the database for a user matching the provided email.
        $user = User::where('USER_MAIL', '=', $mail)->first();

        // Check if a user is found and the provided password matches the hashed password in the database.
        if ($user && Hash::check($password, $user->USER_PASSWORD)) {
            // Debugging purpose: Print user object (not recommended in production).
            echo $user;

            // Store user information in the session for subsequent requests.
            Session::put('user_mail', $user->USER_MAIL);
            Session::put('user_firstname', $user->USER_FIRSTNAME);
            Session::put('user_lastname', $user->USER_LASTNAME);
            Session::put('user_phonenumber', $user->USER_PHONENUMBER);
            Session::put('user_birthdate', $user->USER_BIRTHDATE);
            Session::put('user_address', $user->USER_ADDRESS);
            Session::put('user_postalcode', $user->USER_POSTALCODE);
            Session::put('user_licensenumber', $user->USER_LICENSENUMBER);
            Session::put('user_mediccertificatedate', $user->MEDICCERTIFICATEDATE);
            Session::put('user_id', $user->USER_ID);
            Session::put('level_id', $user->LEVEL_ID);
            Session::put('level_id_resume', $user->LEVEL_ID_RESUME);
            Session::put('type_id', $user->TYPE_ID);
            Session::put('train_id', $user->TRAIN_ID);
            if($user->USER_ISFIRSTLOGIN == 1) {
               return redirect()->route('firstconnexion', ['user' => $user]);
            }
            return redirect()->route('home');


        } else {
            // Flash a failure message to the session for feedback.
            Session::flash('fail', 1);

            // Redirect back to the login page with the previously entered input.
            return back()->withInput();
        }
    }
}

?>
