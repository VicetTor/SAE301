<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
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
        // Validation des informations d'identification
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tentative de connexion avec les identifiants fournis
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            // Vous pouvez renvoyer une réponse simple pour indiquer que l'utilisateur est connecté
            return response()->json([
                'message' => 'Successfully logged in',
                'user' => $user
            ]);
        }

        // Si l'authentification échoue
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
?>