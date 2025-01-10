<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ModificationUserController extends Controller
{

    /**
     * Displays the page with all active users (excluding admins).
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function show()
    {

        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $club = DB::table('report')
        ->where('report.USER_ID' , '=', Session('user_id'))
        ->first();


        $users = User::where('USER_ISACTIVE', 1)
                    ->join('report' , 'report.USER_ID', '=','grp2_user.USER_ID')
                      ->where('TYPE_ID', '!=', 4)
                      ->where('CLUB_ID', '=', $club->CLUB_ID)
                      ->get();

        return view('ModificationUser', ['users' => $users, 'clubs_id' => $club]);
    }

    /**
     * Searches for users by first name, last name, or license number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */

    /**
     * @OA\Get(
     *     path="/api/users/search",
     *     summary="Searches for users by first name, last name, or license number",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=true,
     *         description="Search term",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users matching the search term",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function search(Request $request)
    {
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $club = DB::table('report')
        ->where('report.user_id' , '=', Session('user_id'))
        ->first();

        $searchTerm = $request->input('search');

        // Query users matching the search term in first name, last name, or license number.
        $users = User::join('report' , 'report.user_id', '=','grp2_user.user_id')
                    ->where('USER_FIRSTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LASTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LICENSENUMBER', 'LIKE', "%$searchTerm%")
                    ->get();


        

        // Check if the authenticated user has edit permissions (TYPE_ID == 4).
        $canEdit = Auth::check() && Auth::user()->TYPE_ID == 4;

        return view('ModificationUser', ['users' => $users, 'canEdit' => $canEdit, 'clubs_id' => $club]);
    }

    /**
     * Displays the edit page for a specific user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */

    public function edit($id)
    {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
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

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Updates a user's information",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"USER_FIRSTNAME", "USER_LASTNAME", "USER_LICENSENUMBER", "USER_MAIL", "USER_PHONENUMBER", "USER_ADDRESS", "USER_POSTALCODE", "TYPE_ID", "LEVEL_ID_RESUME", "USER_MEDICCERTIFICATEDATE"},
     *             @OA\Property(property="USER_FIRSTNAME", type="string"),
     *             @OA\Property(property="USER_LASTNAME", type="string"),
     *             @OA\Property(property="USER_LICENSENUMBER", type="string"),
     *             @OA\Property(property="USER_MAIL", type="string"),
     *             @OA\Property(property="USER_PHONENUMBER", type="string"),
     *             @OA\Property(property="USER_ADDRESS", type="string"),
     *             @OA\Property(property="USER_POSTALCODE", type="string"),
     *             @OA\Property(property="TYPE_ID", type="integer"),
     *             @OA\Property(property="LEVEL_ID_RESUME", type="integer"),
     *             @OA\Property(property="USER_MEDICCERTIFICATEDATE", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User information successfully updated",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="User information successfully updated"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {

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

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Deactivates a user by setting USER_ISACTIVE to 0",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User successfully deactivated",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="User successfully deactivated"))
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function delete($id)
    {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
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
