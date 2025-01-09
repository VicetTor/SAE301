<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ModificationUserController extends Controller {

    /**
     * Displays the page with all active users (excluding admins).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show() {

        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $club = DB::table('report')
        ->where('report.user_id' , '=', Session('user_id'))
        ->first();
        

        $users = User::where('USER_ISACTIVE', 1)
                    ->join('report' , 'report.user_id', '=','grp2_user.user_id')
                      ->where('TYPE_ID', '!=', 4)
                      ->where('CLUB_ID', '=', $club->CLUB_ID)
                      ->get();
        
        $canEdit = session('type_id') == 4; 

        // If the user has edit permissions, show the modification page.
        if ($canEdit) {
            return view('ModificationUser', ['users' => $users, 'canEdit' => $canEdit]);
        } else {
            // Redirect unauthorized users to the home page.
            return view('Home');
        }
    }

    /**
     * Searches for users by first name, last name, or license number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request) {
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $searchTerm = $request->input('search');

        // Query users matching the search term in first name, last name, or license number.
        $users = User::where('USER_FIRSTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LASTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LICENSENUMBER', 'LIKE', "%$searchTerm%")
                    ->get();
        
        // Check if the authenticated user has edit permissions (TYPE_ID == 4).
        $canEdit = Auth::check() && Auth::user()->TYPE_ID == 4; 

        return view('ModificationUser', ['users' => $users, 'canEdit' => $canEdit]);
    }

    /**
     * Displays the edit page for a specific user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function edit($id) {
        // Only users with TYPE_ID == 4 can edit users.
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        
        // Find the user by ID.
        $user = User::find($id);

        // Return the edit user view.
        return view('EditUser', ['user' => $user]);
    }

    /**
     * Updates a user's information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
       
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        // Find the user by ID.
        $user = User::find($id);

        if ($user) {
            // Update the user's information with the request data.
            $user->USER_FIRSTNAME = $request->input('USER_FIRSTNAME');
            $user->USER_LASTNAME = $request->input('USER_LASTNAME');
            $user->USER_LICENSENUMBER = $request->input('USER_LICENSENUMBER');
            $user->USER_MAIL = $request->input('USER_MAIL');
            $user->USER_PHONENUMBER = $request->input('USER_PHONENUMBER');
            $user->USER_ADDRESS = $request->input('USER_ADDRESS');
            $user->USER_POSTALCODE = $request->input('USER_POSTALCODE');
            $user->TYPE_ID = $request->input('TYPE_ID');
            $user->LEVEL_ID_RESUME = $request->input('LEVEL_ID_RESUME');
            $user->USER_MEDICCERTIFICATEDATE = $request->input('USER_MEDICCERTIFICATEDATE');
            $user->save(); // Save changes to the database.
        }

        // Redirect back to the modification page with a success message.
        return redirect()->route('modification.users')->with('success', 'User information successfully updated.');
    }

    /**
     * Deactivates a user by setting USER_ISACTIVE to 0.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id) {
        // Only users with TYPE_ID == 4 can delete users.
        if (session('type_id') != 4) {
            return redirect()->route('modification.users')->with('error', 'You are not authorized to delete users.');
        }

        // Find the user by ID.
        $user = User::find($id);

        if ($user) {
            // Deactivate the user by setting USER_ISACTIVE to 0.
            $user->USER_ISACTIVE = 0;
            $user->save(); // Save changes to the database.
        }

        // Redirect back to the modification page with a success message.
        return redirect()->route('modification.users')->with('success', 'User successfully deactivated.');
    }
    
}

?>
