<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class TrainingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/trainings",
     *     summary="Get list of trainings",
     *     tags={"Trainings"},
     *     @OA\Response(
     *         response=200,
     *         description="List of trainings",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Training")
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
        $trainings = Training::all();
        return response()->json($trainings);
    }

    /**
     * @OA\Get(
     *     path="/api/trainings/{id}",
     *     summary="Get a specific training by ID",
     *     tags={"Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the training",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Training found",
     *         @OA\JsonContent(ref="#/components/schemas/Training")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Training not found"
     *     )
     * )
     */
    public function show($id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404);
        }

        return response()->json($training);
    }

    /**
     * @OA\Post(
     *     path="/api/trainings",
     *     summary="Create a new training",
     *     tags={"Trainings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"TRAIN_ID"},
     *             @OA\Property(property="TRAIN_ID", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Training created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Training")
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
            'TRAIN_ID' => 'required|integer',
        ]);

        $training = Training::create($validated);

        return response()->json($training, 201); // 201 signifie "créé"
    }

    /**
     * @OA\Put(
     *     path="/api/trainings/{id}",
     *     summary="Update an existing training",
     *     tags={"Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the training",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"TRAIN_ID"},
     *             @OA\Property(property="TRAIN_ID", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Training updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Training")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Training not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404);
        }

        $validated = $request->validate([
            'TRAIN_ID' => 'required|integer',
        ]);

        $training->update($validated);

        return response()->json($training);
    }

    /**
     * @OA\Delete(
     *     path="/api/trainings/{id}",
     *     summary="Delete a specific training",
     *     tags={"Trainings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the training",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Training deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Training not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $training = Training::find($id);

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404);
        }

        $training->delete();

        return response()->json(['message' => 'Training deleted successfully']);
    }
}
?>
