<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use OpenApi\Annotations as OA;

class FirstConnexionController extends Controller
{
    public $utilisateurId = null;

    /**
     * @OA\Get(
     *     path="/api/first-connexion",
     *     summary="Display the 'First Connection' form for a specific user",
     *     tags={"First Connexion"},
     *     @OA\Parameter(
     *         name="user",
     *         in="query",
     *         required=true,
     *         description="The ID of the user",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="First connection form displayed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="utilisateur", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function show(Request $request)
    {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $utilisateurId = $request->query('user');
        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        if (!$utilisateur) {
            return response()->json(['message' => 'User not found'], 404);
        }

        Session::put('user_id', $utilisateurId);

        // Pass the retrieved user data to the 'FirstConnexion' view
        return view('FirstConnexion', ['utilisateur' => $utilisateur]);
    }

    /**
     * @OA\Post(
     *     path="/api/first-connexion",
     *     summary="Handle the form submission for setting a new password during the first login",
     *     tags={"First Connexion"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"inputNewPassword", "inputPasswordVerif"},
     *             @OA\Property(property="inputNewPassword", type="string", description="The new password"),
     *             @OA\Property(property="inputPasswordVerif", type="string", description="The confirmation of the new password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password updated successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Password updated successfully"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="The new password does not match the verification"
     *     )
     * )
     */
    public function fill(Request $request) {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        // Get the new, and confirmation password from the request
        $inputNewPswd = $request->input('inputNewPassword');
        $inputPswdVerif = $request->input('inputPasswordVerif');

        // Fetch the user's current password from the database
        $userPswd = DB::table('grp2_user')
            ->select('*')
            ->where('USER_ID','=', Session('user_id')) // Find the user by user_id (from session)
            ->first();

        // Check if the new password matches the confirmation
        if ($inputNewPswd === $inputPswdVerif) {
            // Update the user's password in the database
            $testUpdate = DB::table('grp2_user')
                ->where('USER_ID','=', Session('user_id'))
                ->update(['USER_PASSWORD' => Hash::make($inputNewPswd), 'USER_ISFIRSTLOGIN' => 0]); // Hash the new password before saving

            // Redirect to the profile page with a success message
            return redirect()->route('home');
        } else {
            // Return an error if the new password doesn't match the confirmation
            Session::flush();
            return redirect()->back()->withErrors(['inputNewPassword' => 'The new password does not match the verification.']);
        }
    }
}
