<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class AbilityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/abilities",
     *     summary="Get a list of all abilities",
     *     tags={"Abilities"},
     *     @OA\Response(
     *         response=200,
     *         description="List of abilities",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Ability")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     )
     * )
     */
    public function index()
    {
        // Retrieve all abilities from the database
        $abilities = Ability::all();
        // Return the abilities as a JSON response
        return response()->json($abilities);
    }

    /**
     * @OA\Get(
     *     path="/api/abilities/{id}",
     *     summary="Get a specific ability by ID",
     *     tags={"Abilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the ability",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ability found",
     *         @OA\JsonContent(ref="#/components/schemas/Ability")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ability not found"
     *     )
     * )
     */
    public function show($id)
    {
        // Find the ability by ID
        $ability = Ability::find($id);

        // Check if the ability exists
        if ($ability) {
            // Return the ability as a JSON response
            return response()->json($ability);
        } else {
            // Return a 404 not found response
            return response()->json(['message' => 'Ability not found'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/abilities",
     *     summary="Create a new ability",
     *     tags={"Abilities"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"SKILL_ID", "ABI_LABEL"},
     *             @OA\Property(property="SKILL_ID", type="integer"),
     *             @OA\Property(property="ABI_LABEL", type="string", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ability created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ability")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_LABEL' => 'required|string|max:255',
        ]);

        // Create a new ability with the validated data
        $ability = Ability::create($validated);

        // Return the created ability as a JSON response with a 201 status code
        return response()->json($ability, 201); // 201 means "created"
    }

    /**
     * @OA\Put(
     *     path="/api/abilities/{id}",
     *     summary="Update an existing ability",
     *     tags={"Abilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the ability",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Ability")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ability updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ability")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ability not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_LABEL' => 'required|string|max:255',
        ]);

        // Find the ability by ID
        $ability = Ability::find($id);

        // Check if the ability exists
        if ($ability) {
            // Update the ability with the validated data
            $ability->update($validated);

            // Return the updated ability as a JSON response
            return response()->json($ability);
        } else {
            // Return a 404 not found response
            return response()->json(['message' => 'Ability not found'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/abilities/{id}",
     *     summary="Delete an ability",
     *     tags={"Abilities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the ability",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Ability deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ability not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Find the ability by ID
        $ability = Ability::find($id);

        // Check if the ability exists
        if ($ability) {
            // Delete the ability
            $ability->delete();

            // Return a 204 no content response
            return response()->json(null, 204); // 204 means "no content"
        } else {
            // Return a 404 not found response
            return response()->json(['message' => 'Ability not found'], 404);
        }
    }
}