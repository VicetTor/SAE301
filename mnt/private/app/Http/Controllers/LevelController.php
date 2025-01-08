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
        $levels = Level::all();
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
        $level = Level::find($id);

        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

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
        $validated = $request->validate([
            'LEVEL_LABEL' => 'required|string|max:255',
        ]);

        $level = Level::create($validated);

        return response()->json($level, 201); // 201 signifie "créé"
    }

    /**
     * @OA\Put(
     *     path="/api/levels/{id}",
     *     summary="Update existant level",
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
        $level = Level::find($id);

        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

        $validated = $request->validate([
            'LEVEL_LABEL' => 'required|string|max:255',
        ]);

        $level->update($validated);

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
        $level = Level::find($id);

        if (!$level) {
            return response()->json(['error' => 'Level not found'], 404);
        }

        $level->delete();

        return response()->json(['message' => 'Level deleted successfully']);
    }
}
?>