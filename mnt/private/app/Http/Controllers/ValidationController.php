<?php

namespace App\Http\Controllers;

use App\Models\Validation;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ValidationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/validations",
     *     summary="Retrieve all validations",
     *     tags={"Validations"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all validations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Validation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function index()
    {
        $validations = Validation::all();
        return response()->json($validations);
    }

    /**
     * @OA\Get(
     *     path="/api/validations/{id}",
     *     summary="Retrieve a specific validation by ID",
     *     tags={"Validations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Validation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validation found",
     *         @OA\JsonContent(ref="#/components/schemas/Validation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Validation not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        $validation = Validation::find($id);

        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404);
        }

        return response()->json($validation);
    }

    /**
     * @OA\Post(
     *     path="/api/validations",
     *     summary="Create a new validation",
     *     tags={"Validations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"SKILL_ID", "ABI_ID", "LEVEL_ID", "EVAL_ID", "VALID_DATE"},
     *             @OA\Property(property="SKILL_ID", type="integer", example=1),
     *             @OA\Property(property="ABI_ID", type="integer", example=2),
     *             @OA\Property(property="LEVEL_ID", type="integer", example=3),
     *             @OA\Property(property="EVAL_ID", type="integer", example=4),
     *             @OA\Property(property="VALID_DATE", type="string", format="date", example="2023-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Validation created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Validation")
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_ID' => 'required|integer',
            'LEVEL_ID' => 'required|integer',
            'EVAL_ID' => 'required|integer',
            'VALID_DATE' => 'required|date',
        ]);

        $validation = Validation::create($validated);

        return response()->json($validation, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/validations/{id}",
     *     summary="Update an existing validation",
     *     tags={"Validations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Validation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"SKILL_ID", "ABI_ID", "LEVEL_ID", "EVAL_ID", "VALID_DATE"},
     *             @OA\Property(property="SKILL_ID", type="integer", example=1),
     *             @OA\Property(property="ABI_ID", type="integer", example=2),
     *             @OA\Property(property="LEVEL_ID", type="integer", example=3),
     *             @OA\Property(property="EVAL_ID", type="integer", example=4),
     *             @OA\Property(property="VALID_DATE", type="string", format="date", example="2023-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validation updated",
     *         @OA\JsonContent(ref="#/components/schemas/Validation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Validation not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validation = Validation::find($id);

        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404);
        }

        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_ID' => 'required|integer',
            'LEVEL_ID' => 'required|integer',
            'EVAL_ID' => 'required|integer',
            'VALID_DATE' => 'required|date',
        ]);

        $validation->update($validated);

        return response()->json($validation);
    }

    /**
     * @OA\Delete(
     *     path="/api/validations/{id}",
     *     summary="Delete a validation",
     *     tags={"Validations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Validation ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Validation deleted",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Validation deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Validation not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy($id)
    {
        $validation = Validation::find($id);

        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404);
        }

        $validation->delete();

        return response()->json(['message' => 'Validation deleted successfully']);
    }
}
?>