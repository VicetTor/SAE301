<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Club",
 *     type="object",
 *     required={"club_name", "club_postalcode", "club_city", "club_address"},
 *     @OA\Property(property="id", type="integer", description="Club ID"),
 *     @OA\Property(property="club_name", type="string", description="Club name"),
 *     @OA\Property(property="club_postalcode", type="integer", description="Postal code"),
 *     @OA\Property(property="club_city", type="string", description="City"),
 *     @OA\Property(property="club_address", type="string", description="Address")
 * )
 */

class ClubController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clubs",
     *     summary="Retrieve all clubs",
     *     tags={"Clubs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all clubs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Club")
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
        // Fetch all clubs from the database
        $clubs = Club::all();

        // Return the list of clubs as a JSON response
        return response()->json($clubs);
    }

    /**
     * @OA\Get(
     *     path="/api/clubs/{id}",
     *     summary="Retrieve a specific club by ID",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Club ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Club found",
     *         @OA\JsonContent(ref="#/components/schemas/Club")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show($id)
    {
        // Find the club by its ID
        $club = Club::find($id);

        // If the club does not exist, return a 404 error response
        if (!$club) {
            return response()->json(['error' => 'Club not found'], 404);
        }

        // Return the found club as a JSON response
        return response()->json($club);
    }

    /**
     * @OA\Post(
     *     path="/api/clubs",
     *     summary="Create a new club",
     *     tags={"Clubs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"club_name", "club_postalcode", "club_city", "club_address"},
     *             @OA\Property(property="club_name", type="string", example="Football Club"),
     *             @OA\Property(property="club_postalcode", type="integer", example=75001),
     *             @OA\Property(property="club_city", type="string", example="Paris"),
     *             @OA\Property(property="club_address", type="string", example="123 Main St")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Club created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Club")
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
        // Validate the incoming request data
        $validated = $request->validate([
            'club_name' => 'required|string|max:255', // Club name is required and must not exceed 255 characters
            'club_postalcode' => 'required|integer', // Postal code is required and must be an integer
            'club_city' => 'required|string|max:255', // City name is required and must not exceed 255 characters
            'club_address' => 'required|string|max:255', // Address is required and must not exceed 255 characters
        ]);

        // Create a new club with the validated data
        $club = Club::create($validated);

        // Return the created club with a 201 status code
        return response()->json($club, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/clubs/{id}",
     *     summary="Update an existing club",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Club ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"club_name", "club_postalcode", "club_city", "club_address"},
     *             @OA\Property(property="club_name", type="string"),
     *             @OA\Property(property="club_postalcode", type="integer"),
     *             @OA\Property(property="club_city", type="string"),
     *             @OA\Property(property="club_address", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Club updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Club")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Find the club by its ID
        $club = Club::find($id);

        // If the club does not exist, return a 404 error response
        if (!$club) {
            return response()->json(['error' => 'Club not found'], 404);
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'club_name' => 'required|string|max:255',
            'club_postalcode' => 'required|integer',
            'club_city' => 'required|string|max:255',
            'club_address' => 'required|string|max:255',
        ]);

        // Update the club with the validated data
        $club->update($validated);

        // Return the updated club as a JSON response
        return response()->json($club);
    }

    /**
     * @OA\Delete(
     *     path="/api/clubs/{id}",
     *     summary="Delete a specific club",
     *     tags={"Clubs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Club ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Club deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy($id)
    {
        // Find the club by its ID
        $club = Club::find($id);

        // If the club does not exist, return a 404 error response
        if (!$club) {
            return response()->json(['error' => 'Club not found'], 404);
        }

        // Delete the club from the database
        $club->delete();

        // Return a success message
        return response()->json(['message' => 'Club deleted successfully']);
    }
}