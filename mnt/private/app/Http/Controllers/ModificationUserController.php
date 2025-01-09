<?php

namespace App\Http\Controllers;

use App\Models\User; // Importing the User model
use Illuminate\Http\Request; // For handling HTTP requests
use Illuminate\Support\Facades\Auth; // For authentication
use Illuminate\Support\Facades\Session; // For session management

class ModificationUserController extends Controller {

    /**
     * Displays the page with all active users (excluding admins).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show() {
        // Fetch users who are active and not admins (TYPE_ID != 1).
        $users = User::where('USER_ISACTIVE', 1)
                      ->where('TYPE_ID', '!=', 1)
                      ->get();
        
        // Check if the current user has the appropriate permissions (TYPE_ID == 4).
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
        // Get the search term from the request.
        $searchTerm = $request->input('search');

        // Query users matching the search term in first name, last name, or license number.
        $users = User::where('USER_FIRSTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LASTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LICENSENUMBER', 'LIKE', "%$searchTerm%")
                    ->get();
        
        // Check if the authenticated user has edit permissions (TYPE_ID == 4).
        $canEdit = Auth::check() && Auth::user()->TYPE_ID == 4; 

        // Return the modification page view with the search results.
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
            return redirect()->route('modification.users')->with('error', 'You are not authorized to edit users.');
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
        // Only users with TYPE_ID == 4 can update user information.
        if (session('type_id') != 4) {
            return redirect()->route('modification.users')->with('error', 'You are not authorized to update users.');
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
