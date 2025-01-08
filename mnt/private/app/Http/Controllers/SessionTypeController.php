<?php

namespace App\Http\Controllers;

use App\Models\SessionType;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class SessionTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/session-types",
     *     summary="Retrieve all session types",
     *     tags={"Session Types"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all session types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/SessionType")
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
        $sessionTypes = SessionType::all();
        return response()->json($sessionTypes);
    }

    /**
     * @OA\Get(
     *     path="/api/session-types/{id}",
     *     summary="Retrieve a specific session type by ID",
     *     tags={"Session Types"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Session Type ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session type found",
     *         @OA\JsonContent(ref="#/components/schemas/SessionType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session type not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        $sessionType = SessionType::find($id);

        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        return response()->json($sessionType);
    }

    /**
     * @OA\Post(
     *     path="/api/session-types",
     *     summary="Create a new session type",
     *     tags={"Session Types"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"SESSTYPE_LABEL"},
     *             @OA\Property(property="SESSTYPE_LABEL", type="string", example="Theoretical training")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Session Type Created",
     *         @OA\JsonContent(ref="#/components/schemas/SessionType")
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
            'SESSTYPE_LABEL' => 'required|string|max:255',
        ]);

        $sessionType = SessionType::create($validated);

        return response()->json($sessionType, 201); // 201 signifie "créé"
    }

    /**
     * @OA\Put(
     *     path="/api/session-types/{id}",
     *     summary="Update an existing session type",
     *     tags={"Session Types"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Session Type ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"SESSTYPE_LABEL"},
     *             @OA\Property(property="SESSTYPE_LABEL", type="string", example="Practical training")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session type updated",
     *         @OA\JsonContent(ref="#/components/schemas/SessionType")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session type not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $sessionType = SessionType::find($id);

        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        $validated = $request->validate([
            'SESSTYPE_LABEL' => 'required|string|max:255',
        ]);

        $sessionType->update($validated);

        return response()->json($sessionType);
    }

    /**
     * @OA\Delete(
     *     path="/api/session-types/{id}",
     *     summary="Delete a session type",
     *     tags={"Session Types"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Session Type ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Session type deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Session type deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Session type not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy($id)
    {
        $sessionType = SessionType::find($id);

        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        $sessionType->delete();

        return response()->json(['message' => 'Session type deleted successfully']);
    }
}
?>