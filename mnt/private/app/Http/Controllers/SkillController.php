<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SkillController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/skills",
     *     summary="Collect all skills",
     *     tags={"Skills"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all skills",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Skill")
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
        // Retrieve all skills from the database
        $skills = Skill::all();
        // Return the skills as a JSON response
        return response()->json($skills);
    }

    /**
     * @OA\Get(
     *     path="/api/skills/{id}",
     *     summary="Retrieve a specific skill by ID",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Skill ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill found",
     *         @OA\JsonContent(ref="#/components/schemas/Skill")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        // Find the skill by its ID
        $skill = Skill::find($id);

        // If the skill is not found, return a 404 error with a message
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        // Return the skill as a JSON response
        return response()->json($skill);
    }

    /**
     * @OA\Post(
     *     path="/api/skills",
     *     summary="Create a new skill",
     *     tags={"Skills"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL_ID", "SKILL_LABEL"},
     *             @OA\Property(property="LEVEL_ID", type="integer", example=1),
     *             @OA\Property(property="SKILL_LABEL", type="string", example="Programming skills")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Skill created",
     *         @OA\JsonContent(ref="#/components/schemas/Skill")
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
        // Validate the incoming data
        $validated = $request->validate([
            'LEVEL_ID' => 'required|integer', // LEVEL_ID must be an integer
            'SKILL_LABEL' => 'required|string|max:255', // SKILL_LABEL must be a string, max length of 255
        ]);

        // Create a new skill entry using the validated data
        $skill = Skill::create($validated);

        // Return a JSON response with the created skill and a 201 status code (Created)
        return response()->json($skill, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/skills/{id}",
     *     summary="Update an existing skill",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Skill ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"LEVEL_ID", "SKILL_LABEL"},
     *             @OA\Property(property="LEVEL_ID", type="integer", example=2),
     *             @OA\Property(property="SKILL_LABEL", type="string", example="Graphic design skills")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill updated",
     *         @OA\JsonContent(ref="#/components/schemas/Skill")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Find the skill by ID
        $skill = Skill::find($id);

        // If the skill is not found, return a 404 error with a message
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        // Validate the incoming data
        $validated = $request->validate([
            'LEVEL_ID' => 'required|integer',
            'SKILL_LABEL' => 'required|string|max:255',
        ]);

        // Update the skill with the validated data
        $skill->update($validated);

        // Return the updated skill as a JSON response
        return response()->json($skill);
    }

    /**
     * @OA\Delete(
     *     path="/api/skills/{id}",
     *     summary="Delete a skill",
     *     tags={"Skills"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Skill ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Skill removed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Skill deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Skill not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Find the skill by ID
        $skill = Skill::find($id);

        // If the skill is not found, return a 404 error with a message
        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        // Delete the skill
        $skill->delete();

        // Return a success message in the JSON response
        return response()->json(['message' => 'Skill deleted successfully']);
    }
}
?>
