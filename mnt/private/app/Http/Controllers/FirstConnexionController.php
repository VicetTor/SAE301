<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // Importing Session for session management

class FirstConnexionController extends Controller
{
    /**
     * Display the "First Connection" form for a specific user.
     *
     * @param  Request  $request  The HTTP request object.
     * @return \Illuminate\View\View  The view for first connection.
     */

     public $utilisateurId = null;


    public function show(Request $request){

        $utilisateurId = $request->query('user');
        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        Session::put('user_id',$utilisateurId);

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
         // Get the new, and confirmation password from the request

         $inputNewPswd = $request->input('inputNewPassword'); 
         $inputPswdVerif = $request->input('inputPasswordVerif'); 
 
         // Fetch the user's current password from the database
         $userPswd = DB::table('grp2_user')
             ->select('*')
             ->where('USER_ID','=', Session('user_id')) // Find the user by user_id (from session)
             ->first();
 
         // Check if the entered current password matches the one in the database
         
             // Check if the new password matches the confirmation
             if($inputNewPswd === $inputPswdVerif){
                 // Update the user's password in the database
                 $testUpdate = DB::table('grp2_user')
                     ->where('user_id','=', Session('user_id'))
                     ->update(['user_password' => Hash::make($inputNewPswd), 'user_isfirstlogin' => 0]); // Hash the new password before saving
 
                 // Redirect to the profile page with a success message
                

                 return redirect()->route('home');
             }
             else
             {
                 // Return an error if the new password doesn't match the confirmation
                 Session::flush();
                 return redirect()->back()->withErrors(['inputNewPassword' => 'The new password does not match the verification.']);
             }
    }
}
