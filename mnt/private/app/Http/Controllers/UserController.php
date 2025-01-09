<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Retrieve all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    // This function returns a list of all users in the database.
    public function index()
    {
        $users = User::all(); // Retrieve all user records from the database.
        return response()->json($users); // Return the list of users as a JSON response.
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Retrieve a specific user by ID",
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
     *         description="User found",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    // This function retrieves a specific user from the database by their ID.
    public function show($id)
    {
        $user = User::find($id); // Find the user by their ID.
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404); // Return a 404 error if the user is not found.
        }
        return response()->json($user); // Return the user details as a JSON response.
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"USER_MAIL", "USER_PASSWORD"},
     *             @OA\Property(property="USER_MAIL", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="USER_PASSWORD", type="string", format="password", example="secretpassword")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    // This function creates a new user in the database.
    public function store(Request $request)
    {
        // Validate the request data for the user's email and password.
        $validated = $request->validate([
            'USER_MAIL' => 'required|email', // Ensure the email is valid.
            'USER_PASSWORD' => 'required|string|min:6', // Ensure the password is a string and at least 6 characters long.
        ]);

        // Create the new user with the validated data.
        $user = User::create($validated);
        return response()->json($user, 201); // Return the created user as a JSON response with a 201 status.
    }
}
?>
