<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class LevelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/levels",
     *     summary="Get all levels",
     *     tags={"Levels"},
     *     @OA\Response(
     *         response=200,
     *         description="List of levels",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Level")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Levels not found"
     *     )
     * )
     */
    public function index()
    {
        // Fetch all records from the Level model
        $levels = Level::all();

        // Return the levels as a JSON response
        return response()->json($levels);
    }

    /**
     * @OA\Get(
     *     path="/api/levels/{id}",
     *     summary="Pick-up a specific level by ID",
     *     tags={"Levels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID level",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Find level",
     *         @OA\JsonContent(ref="#/components/schemas/Level")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Level not find"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        // Find a specific level by its ID
        $level = Level::find($id);

        // If the level is not found, return a 404 error
        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

        // Return the level as a JSON response
        return response()->json($level);
    }

    /**
     * @OA\Post(
     *     path="/api/levels",
     *     summary="Create a new level",
     *     tags={"Levels"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL_LABEL"},
     *             @OA\Property(property="LEVEL_LABEL", type="string", example="Beginner")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Level created",
     *         @OA\JsonContent(ref="#/components/schemas/Level")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validate the input data, requiring 'LEVEL_LABEL' to be a string with a max length of 255
        $validated = $request->validate([
            'LEVEL_LABEL' => 'required|string|max:255',
        ]);

        // Create a new Level record using the validated data
        $level = Level::create($validated);

        // Return the newly created level as a JSON response with a 201 status code
        return response()->json($level, 201); // 201 signifies "Created"
    }

    /**
     * @OA\Put(
     *     path="/api/levels/{id}",
     *     summary="Update existing level",
     *     tags={"Levels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Level",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL_LABEL"},
     *             @OA\Property(property="LEVEL_LABEL", type="string", example="Advanced")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Level updated",
     *         @OA\JsonContent(ref="#/components/schemas/Level")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Level not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Find the level by ID
        $level = Level::find($id);

        // If the level is not found, return a 404 error
        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

        // Validate the input data
        $validated = $request->validate([
            'LEVEL_LABEL' => 'required|string|max:255',
        ]);

        // Update the level record with the validated data
        $level->update($validated);

        // Return the updated level as a JSON response
        return response()->json($level);
    }

    /**
     * @OA\Delete(
     *     path="/api/levels/{id}",
     *     summary="Delete a level",
     *     tags={"Levels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID Level",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Deleted level",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Level deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Level not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Find the level by ID
        $level = Level::find($id);

        // If the level is not found, return a 404 error
        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

        // Delete the level record
        $level->delete();

        // Return a success message as a JSON response
        return response()->json(['message' => 'Level deleted successfully']);
    }
}
