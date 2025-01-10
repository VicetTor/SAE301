<?php

namespace App\Http\Controllers;

use App\Models\SessionType; // Import the SessionType model
use Illuminate\Http\Request; // Import the Request class to handle incoming HTTP requests
use OpenApi\Annotations as OA; // Import OpenAPI annotations for documentation

/**
 * @OA\Schema(
 *     schema="SessionType",
 *     type="object",
 *     required={"SESSTYPE_LABEL"},
 *     @OA\Property(property="id", type="integer", description="Session Type ID"),
 *     @OA\Property(property="SESSTYPE_LABEL", type="string", description="Session Type Label")
 * )
 */

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
        // Retrieve all session types from the SessionType model and return them as JSON
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
        // Find the session type by ID
        $sessionType = SessionType::find($id);

        // If the session type is not found, return a 404 error
        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        // Return the session type as JSON if found
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
        // Validate the incoming request data
        $validated = $request->validate([
            'SESSTYPE_LABEL' => 'required|string|max:255',
        ]);

        // Create a new session type record using the validated data
        $sessionType = SessionType::create($validated);

        // Return the newly created session type with a 201 status code (created)
        return response()->json($sessionType, 201);
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
        // Find the session type by ID
        $sessionType = SessionType::find($id);

        // If the session type is not found, return a 404 error
        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'SESSTYPE_LABEL' => 'required|string|max:255',
        ]);

        // Update the session type record with the validated data
        $sessionType->update($validated);

        // Return the updated session type as JSON
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
        // Find the session type by ID
        $sessionType = SessionType::find($id);

        // If the session type is not found, return a 404 error
        if (!$sessionType) {
            return response()->json(['error' => 'Session type not found'], 404);
        }

        // Delete the session type record
        $sessionType->delete();

        // Return a success message upon successful deletion
        return response()->json(['message' => 'Session type deleted successfully']);
    }
}