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
     *     summary="Get list of abilities",
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
        $abilities = Ability::all();
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
        $ability = Ability::find($id);

        if (!$ability) {
            return response()->json(['error' => 'Ability not found'], 404);
        }

        return response()->json($ability);
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
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_LABEL' => 'required|string|max:255',
        ]);

        $ability = Ability::create($validated);

        return response()->json($ability, 201); // 201 signifie "créé"
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
     *         @OA\JsonContent(
     *             type="object",
     *             required={"SKILL_ID", "ABI_LABEL"},
     *             @OA\Property(property="SKILL_ID", type="integer"),
     *             @OA\Property(property="ABI_LABEL", type="string", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ability updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Ability")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ability not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $ability = Ability::find($id);

        if (!$ability) {
            return response()->json(['error' => 'Ability not found'], 404);
        }

        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_LABEL' => 'required|string|max:255',
        ]);

        $ability->update($validated);

        return response()->json($ability);
    }

    /**
     * @OA\Delete(
     *     path="/api/abilities/{id}",
     *     summary="Delete a specific ability",
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
        $ability = Ability::find($id);

        if (!$ability) {
            return response()->json(['error' => 'Ability not found'], 404);
        }

        $ability->delete();

        return response()->json(['message' => 'Ability deleted successfully']);
    }
}
?>