<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest; // Import the custom request for validating sign-in form data
use App\Models\Level; // Import the Level model to handle level data
use App\Models\TypeUser; // Import the TypeUser model to handle user type data
use App\Models\User; // Import the User model to handle user data
use Illuminate\Http\Request; // Import the Request class to handle incoming HTTP requests
use Illuminate\Support\Facades\DB; // Import the DB facade to interact with the database
use Illuminate\Support\Facades\Hash; // Import the Hash facade to securely hash passwords
use Nette\Utils\Random; // Import the Random utility class to generate random values

class SignInController extends Controller
{
    /**
     * Display the sign-in form with available user types, levels, and all users.
     * 
     * @return \Illuminate\View\View
     */
    public function show(){
        // Return the 'SignInForm' view with data for user types, levels, and users
        return view('SignInForm', [
            'user' => User::all(), // Retrieve all users
            'typeUser' => TypeUser::all(), // Retrieve all user types
            'levels' => Level::all() // Retrieve all levels
        ]);
    }

    /**
     * Handle the sign-in process by validating and creating a new user.
     * 
     * @param  \App\Http\Requests\CreatePostRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signIn(CreatePostRequest $request){
        // Create a new User instance
        $utilisateur = new User();

        // Assign a unique USER_ID based on the current count of users in the database
        $utilisateur->USER_ID = DB::table('grp2_user')->count() + 1;

        // Set the LEVEL_ID based on user input from the sign-in form
        $utilisateur->LEVEL_ID = $request->input('LEVEL_ID');

        // Set the TYPE_ID based on user input from the sign-in form
        $utilisateur->TYPE_ID = $request->input('TYPE_ID');

        // If the user type is '1', assign a LEVEL_ID_RESUME based on the input, otherwise set it to NULL
        if($request->input('TYPE_ID') == 1){
            $utilisateur->LEVEL_ID_RESUME = $request->input('LEVEL_ID_RESUME');
        }
        else{
            $utilisateur->LEVEL_ID_RESUME = NULL;
        }

        // Set the USER_MAIL, USER_FIRSTNAME, USER_LASTNAME, and other personal details from the form input
        $utilisateur->USER_MAIL = $request->input('USER_MAIL');
        $utilisateur->USER_FIRSTNAME = $request->input('USER_FIRSTNAME');
        $utilisateur->USER_LASTNAME = $request->input('USER_LASTNAME');
        $utilisateur->USER_PHONENUMBER = $request->input('USER_PHONENUMBER');
        $utilisateur->USER_BIRTHDATE = $request->input('USER_BIRTHDATE');
        $utilisateur->USER_ADDRESS = $request->input('USER_ADDRESS');
        $utilisateur->USER_POSTALCODE = $request->input('USER_POSTALCODE');
        $utilisateur->USER_LICENSENUMBER = $request->input('USER_LICENSENUMBER');
        $utilisateur->USER_MEDICCERTIFICATEDATE = $request->input('USER_MEDICCERTIFICATEDATE');

        // Generate a random 6-character password for the user and hash it for storage
        $password_inscription = (Random::generate(6)); // Generate a random password
        $utilisateur->USER_PASSWORD = Hash::make($password_inscription); // Hash the password before saving

        // Set flags for first login and user activity status
        $utilisateur->USER_ISFIRSTLOGIN = 1; // Set the first login flag to true
        $utilisateur->USER_ISACTIVE = 1; // Set the user as active

        // Save the new user to the database
        $utilisateur->save();

        // Redirect to the login page with the newly generated password
        return redirect()->route('connexion', ['password' => $password_inscription]);
    }
}
