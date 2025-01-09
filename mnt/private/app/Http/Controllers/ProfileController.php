<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // For authorization checks
use Illuminate\Foundation\Bus\DispatchesJobs; // For dispatching jobs
use Illuminate\Foundation\Validation\ValidatesRequests; // For validation
use Illuminate\Http\Request; // For handling HTTP requests
use Illuminate\Support\Facades\DB; // For database queries
use Illuminate\Support\Facades\Session; // For session management
use Illuminate\Support\Facades\Hash; // For hashing passwords

class ProfileController extends Controller
{
    // Using traits for authorization, job dispatching, and validation
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Updates the user's information (email, phone, address, postal code).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function infoUpdate(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([ 
            'inputEmail' => 'required|email|max:255', // Email must be valid
            'inputPhoneNumber' => 'required|string|max:15', // Phone number must be a string, max length 15
            'inputAddress' => 'required|string|max:255', // Address must be a string, max length 255
            'inputPostalCode' => 'required|string|size:5', // Postal code must be exactly 5 characters long
        ], [
             // Custom error messages for validation failures
             'inputEmail.required' => 'Email address is required.', 
             'inputEmail.email' => 'Please provide a valid email address.', 
             'inputPhoneNumber.required' => 'Phone number is required.', 
             'inputAddress.required' => 'Address is required.', 
             'inputPostalCode.required' => 'Postal code is required.', 
             'inputPostalCode.size' => 'Postal code must be exactly 5 characters long.'
        ]);
        
        // Retrieve the validated data from the request
        $inputMail = $request->input('inputEmail'); 
        $inputPhoneNumber = $request->input('inputPhoneNumber'); 
        $inputAddress = $request->input('inputAddress'); 
        $inputPostalCode = $request->input('inputPostalCode'); 

        // Update the user information in the database
        $testUpdate = DB::table('grp2_user')
            ->where('user_id','=', session('user_id')) // Find the user by user_id (from session)
            ->update([
                'user_mail' => $inputMail,
                'user_phonenumber' => $inputPhoneNumber,
                'user_address' => $inputAddress,
                'user_postalcode' => $inputPostalCode
            ]);

        // Update the session data with the new values
        Session::put('user_mail',  $inputMail);
        Session::put('user_phonenumber', $inputPhoneNumber);
        Session::put('user_address', $inputAddress);
        Session::put('user_postalcode', $inputPostalCode);

        // Redirect back to the profile page
        return redirect()->route('profile');
    }

    /**
     * Displays the user's profile page with pop-up notifications (if applicable).
     *
     * @return \Illuminate\Contracts\View\View
     */
    function up()
    {
        // Fetch any report pop-ups for the user from the database
        $popUps = DB::table('report')
            ->join('grp2_user','grp2_user.user_id','=','report.user_id') // Join with the user table
            ->join('grp2_club','grp2_club.club_id','=','report.club_id') // Join with the club table
            ->where('type_id','=','3') // Filter for reports of type 3
            ->first(); // Fetch the first record (if exists)

        // Return the profile view with any pop-up notifications
        return view('MyProfile', ['popUps' => $popUps]);
    }

    /**
     * Logs the user out and redirects them to the login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function logOut()
    {
        // Log the user out using Laravel's authentication system
        auth()->logout();
        
        // Clear all session data
        Session::flush();

        // Redirect to the login page
        return redirect()->route('connexion');
    }

    /**
     * Updates the user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function pswdUpdate(Request $request)
    {
        // Get the current, new, and confirmation password from the request
        $inputPswd = $request->input('inputActualPassword'); 
        $inputNewPswd = $request->input('inputNewPassword'); 
        $inputPswdVerif = $request->input('inputPasswordVerif'); 

        // Fetch the user's current password from the database
        $userPswd = DB::table('grp2_user')
            ->select('*')
            ->where('USER_ID','=', session('user_id')) // Find the user by user_id (from session)
            ->first();

        // Check if the entered current password matches the one in the database
        if(Hash::check($inputPswd, $userPswd->USER_PASSWORD)){
            // Check if the new password matches the confirmation
            if($inputNewPswd === $inputPswdVerif){
                // Update the user's password in the database
                $testUpdate = DB::table('grp2_user')
                    ->where('user_id','=', session('user_id'))
                    ->update(['user_password' => Hash::make($inputNewPswd)]); // Hash the new password before saving

                // Redirect to the profile page with a success message
                return redirect()->route('profile')->with('success', 'Password updated successfully.');
            }else{
                // Return an error if the new password doesn't match the confirmation
                return redirect()->back()->withErrors(['inputNewPassword' => 'The new password does not match the verification.']);
            }
        }else{
            // Return an error if the current password is incorrect
            return redirect()->back()->withErrors(['inputActualPassword' => 'The current password is incorrect.']);
        }
    }
}

?>
