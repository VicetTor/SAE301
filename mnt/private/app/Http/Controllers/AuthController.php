<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function login(Request $request) {
        try {
            // Validation des informations d'identification
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Recherche de l'utilisateur avec l'email
            $user = User::where('USER_MAIL', $validated['email'])->first();

            // Vérification de l'existence de l'utilisateur et du mot de passe
            if (!$user || !Hash::check($validated['password'], $user->USER_PASSWORD)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Générer un token d'authentification
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token,
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
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
        // Validation des données de la requête
        $validator = Validator::make($request->all(), [
            'LEVEL_ID' => 'required|integer',
            'TYPE_ID' => 'required|integer',
            'USER_MAIL' => 'required|email|unique:grp2_user,USER_MAIL',
            'USER_PASSWORD' => 'required|string|min:6',
            'USER_FIRSTNAME' => 'required|string|max:255',
            'USER_LASTNAME' => 'required|string|max:255',
            'USER_PHONENUMBER' => 'required|string|max:13',
            'USER_ADDRESS' => 'required|string|max:255',
            'USER_POSTALCODE' => 'required|string|max:5',
            'USER_LICENSENUMBER' => 'required|string|max:32',
            'USER_MEDICCERTIFICATEDATE' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Création de l'utilisateur
        $user = User::create([
            'LEVEL_ID' => $request->LEVEL_ID,
            'TYPE_ID' => $request->TYPE_ID,
            'USER_MAIL' => $request->USER_MAIL,
            'USER_PASSWORD' => Hash::make($request->USER_PASSWORD),
            'USER_FIRSTNAME' => $request->USER_FIRSTNAME,
            'USER_LASTNAME' => $request->USER_LASTNAME,
            'USER_PHONENUMBER' => $request->USER_PHONENUMBER,
            'USER_ADDRESS' => $request->USER_ADDRESS,
            'USER_POSTALCODE' => $request->USER_POSTALCODE,
            'USER_LICENSENUMBER' => $request->USER_LICENSENUMBER,
            'USER_MEDICCERTIFICATEDATE' => $request->USER_MEDICCERTIFICATEDATE,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }
}
?>