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
    // This function retrieves all validation records from the database.
    public function index()
    {
        $validations = Validation::all(); // Fetch all validations from the database.
        return response()->json($validations); // Return the list of validations as a JSON response.
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
    // This function retrieves a specific validation by its ID from the database.
    public function show($id)
    {
        $validation = Validation::find($id); // Find the validation by its ID.
        
        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404); // Return a 404 if validation not found.
        }
        
        return response()->json($validation); // Return the validation details as a JSON response.
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
    // This function creates a new validation entry in the database.
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer', // Validate SKILL_ID as an integer.
            'ABI_ID' => 'required|integer', // Validate ABI_ID as an integer.
            'LEVEL_ID' => 'required|integer', // Validate LEVEL_ID as an integer.
            'EVAL_ID' => 'required|integer', // Validate EVAL_ID as an integer.
            'VALID_DATE' => 'required|date', // Validate VALID_DATE as a date.
        ]);
        
        // Create the validation record using the validated data.
        $validation = Validation::create($validated);
        
        // Return the created validation as a JSON response with a 201 status.
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
    // This function updates an existing validation record by ID.
    public function update(Request $request, $id)
    {
        $validation = Validation::find($id); // Find the validation by its ID.
        
        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404); // Return 404 if validation is not found.
        }
        
        // Validate the incoming request data.
        $validated = $request->validate([
            'SKILL_ID' => 'required|integer',
            'ABI_ID' => 'required|integer',
            'LEVEL_ID' => 'required|integer',
            'EVAL_ID' => 'required|integer',
            'VALID_DATE' => 'required|date',
        ]);
        
        // Update the validation record with the validated data.
        $validation->update($validated);
        
        // Return the updated validation record as a JSON response.
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
    // This function deletes a validation record from the database.
    public function destroy($id)
    {
        $validation = Validation::find($id); // Find the validation by its ID.
        
        if (!$validation) {
            return response()->json(['error' => 'Validation not found'], 404); // Return 404 if validation not found.
        }
        
        $validation->delete(); // Delete the validation record.
        
        // Return a success message indicating the deletion was successful.
        return response()->json(['message' => 'Validation deleted successfully']);
    }
}
?>
