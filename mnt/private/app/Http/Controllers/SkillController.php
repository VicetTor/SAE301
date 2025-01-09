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
        $skills = Skill::all();
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
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

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
        $validated = $request->validate([
            'LEVEL_ID' => 'required|integer',
            'SKILL_LABEL' => 'required|string|max:255',
        ]);

        $skill = Skill::create($validated);

        return response()->json($skill, 201); // 201 signifie "créé"
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
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        $validated = $request->validate([
            'LEVEL_ID' => 'required|integer',
            'SKILL_LABEL' => 'required|string|max:255',
        ]);

        $skill->update($validated);

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
        $skill = Skill::find($id);

        if (!$skill) {
            return response()->json(['error' => 'Skill not found'], 404);
        }

        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully']);
    }
}
?>