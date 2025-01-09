<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FirstConnexionController extends Controller
{
    /**
     * Display the "First Connection" form for a specific user.
     *
     * @param  Request  $request  The HTTP request object.
     * @return \Illuminate\View\View  The view for first connection.
     */
    public function show(Request $request) {
        // Retrieve the user ID from the query parameters
        $utilisateurId = $request->query('utilisateur');
        
        // Fetch the user from the database using the user ID
        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        // Pass the retrieved user data to the 'FirstConnexion' view
        return view('FirstConnexion', ['utilisateur' => $utilisateur]);
    }

    /**
     * Handle the form submission for setting a new password during the first login.
     *
     * @param  Request  $request  The HTTP request object.
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector  Redirect to login or show the form.
     */
    public function fill(Request $request) {
        // Retrieve the user ID from the query parameters
        $utilisateurId = $request->query('utilisateur');

        // Fetch the user from the database using the user ID
        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        // Get the new password from the form input
        $newPassword = $request->input('USER_PASSWORD');

        // If no password is provided, return the form view with the user data
        if (!$newPassword) {
            return view('FirstConnexion', ['utilisateur' => $utilisateur]);
        }

        // Update the user's password and mark the first login flag as false
        DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->update([
                'grp2_user.user_password' => Hash::make($newPassword), // Hash the new password for security
                'grp2_user.user_isfirstlogin' => 0 // Set the first login flag to false
            ]);

        // Redirect the user to the login page after successfully setting a new password
        return redirect()->route('connexion');
    }
}
