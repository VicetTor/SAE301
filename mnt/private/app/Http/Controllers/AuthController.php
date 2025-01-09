<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"id", "email", "first_name", "last_name"},
 *     @OA\Property(property="id", type="integer", description="User ID"),
 *     @OA\Property(property="email", type="string", format="email", description="User email"),
 *     @OA\Property(property="first_name", type="string", description="User first name"),
 *     @OA\Property(property="last_name", type="string", description="User last name"),
 *     @OA\Property(property="phone_number", type="string", description="User phone number"),
 *     @OA\Property(property="address", type="string", description="User address"),
 *     @OA\Property(property="postal_code", type="string", description="User postal code"),
 *     @OA\Property(property="license_number", type="string", description="User license number"),
 *     @OA\Property(property="medical_certificate_date", type="string", format="date", description="User medical certificate date")
 * )
 */

class AuthController extends Controller {
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", description="User email"),
     *             @OA\Property(property="password", type="string", description="User password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged in",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully logged in"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', // Email is required and must be valid
            'password' => 'required|string', // Password is required and must be a string
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Bad request'], 400); // Return error response
        }

        // Retrieve user by email from the database
        $user = DB::table('users')->where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful; additional actions like generating a token could go here

            // Return success response with user data
            return response()->json(['message' => 'Successfully logged in', 'user' => $user], 200);
        } else {
            // Authentication failed; return error response
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="User created successfully"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'LEVEL_ID' => 'required|integer', // User level ID is required and must be an integer
            'TYPE_ID' => 'required|integer', // User type ID is required and must be an integer
            'USER_MAIL' => 'required|email|unique:grp2_user,USER_MAIL', // Email is required, must be valid, and unique
            'USER_PASSWORD' => 'required|string|min:6', // Password is required, must be a string, and have at least 6 characters
            'USER_FIRSTNAME' => 'required|string|max:255', // First name is required and must not exceed 255 characters
            'USER_LASTNAME' => 'required|string|max:255', // Last name is required and must not exceed 255 characters
            'USER_PHONENUMBER' => 'required|string|max:13', // Phone number is required and must not exceed 13 characters
            'USER_ADDRESS' => 'required|string|max:255', // Address is required and must not exceed 255 characters
            'USER_POSTALCODE' => 'required|string|max:5', // Postal code is required and must not exceed 5 characters
            'USER_LICENSENUMBER' => 'required|string|max:32', // License number is required and must not exceed 32 characters
            'USER_MEDICCERTIFICATEDATE' => 'required|date', // Medical certificate date is required and must be a valid date
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400); // Return validation error response
        }

        // Create a new user with the validated data
        $user = User::create([
            'LEVEL_ID' => $request->LEVEL_ID,
            'TYPE_ID' => $request->TYPE_ID,
            'USER_MAIL' => $request->USER_MAIL,
            'USER_PASSWORD' => Hash::make($request->USER_PASSWORD), // Hash the password for security
            'USER_FIRSTNAME' => $request->USER_FIRSTNAME,
            'USER_LASTNAME' => $request->USER_LASTNAME,
            'USER_PHONENUMBER' => $request->USER_PHONENUMBER,
            'USER_ADDRESS' => $request->USER_ADDRESS,
            'USER_POSTALCODE' => $request->USER_POSTALCODE,
            'USER_LICENSENUMBER' => $request->USER_LICENSENUMBER,
            'USER_MEDICCERTIFICATEDATE' => $request->USER_MEDICCERTIFICATEDATE,
        ]);

        // Return success response
        return response()->json(['message' => 'User registered successfully'], 201);
    }
}