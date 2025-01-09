<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request) {
        // Validation des données
        $validated = $request->validate([
            'TRAIN_ID' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'responsable_id' => 'required|exists:users,id', // Vérifier que le responsable existe
        ]);

        // Créer une nouvelle formation avec le responsable
        $training = Training::create([
            'TRAIN_ID' => $validated['TRAIN_ID'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'responsable_id' => $validated['responsable_id']
        ]);

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

    // Affiche le formulaire de sélection d'année
    public function showYearSelectionForm() {
        // Récupérer les années disponibles depuis la base de données
        $years = DB::table('grp2_year')->pluck('ANNU_YEAR');

        return view('selectYear', ['years' => $years]);
    }

    // Gère la soumission du formulaire de sélection d'année
    public function handleYearSelection(Request $request) {
        $year = $request->input('year');

        // Rediriger vers la route d'exportation des données avec l'année sélectionnée
        return redirect()->route('exportTrainingData', ['year' => $year]);
    }

    // Exporte les données de formation en CSV pour une année spécifique
    public function exportTrainingData(Request $request)
    {
        $year = $request->query('year');

        $callback = function() use ($year) {
            $handle = fopen('php://output', 'w');
            // Utiliser des noms de colonnes plus clairs
            fputcsv($handle, ['Numéro de formation', 'Nombre inscrits dans le club', 'Nombre de diplômés', 'Année']);

            $results = DB::select("
                SELECT DISTINCT
                    tra.TRAIN_ID, 
                    tod.CLUB_INSCRIPTIONNB, 
                    tod.CLUB_NBDEGREEOBTAINED, 
                    yea.ANNU_YEAR
                FROM 
                    grp2_user use1
                JOIN 
                    grp2_training tra ON tra.TRAIN_ID = use1.TRAIN_ID
                JOIN 
                    report rep ON rep.USER_ID = use1.USER_ID
                JOIN 
                    grp2_year yea ON yea.ANNU_YEAR = rep.ANNU_YEAR
                JOIN 
                    to_date tod ON tod.CLUB_ID = rep.CLUB_ID AND tod.ANNU_YEAR = yea.ANNU_YEAR
                JOIN 
                    grp2_club clu ON clu.CLUB_ID = rep.CLUB_ID
                WHERE 
                    yea.ANNU_YEAR = ?;
            ", [$year]);

            foreach ($results as $row) {
                fputcsv($handle, (array)$row);
            }

            fclose($handle);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="training_data_'.$year.'.csv"',
        ];

        return response()->stream($callback, 200, $headers);
    }

    // Affiche le graphique avec les données pour toutes les années
    public function showTrainingGraph() {
        $data = DB::select("
            SELECT 
                yea.ANNU_YEAR,
                tra.TRAIN_ID, 
                SUM(tod.CLUB_INSCRIPTIONNB) AS total_inscriptions, 
                SUM(tod.CLUB_NBDEGREEOBTAINED) AS total_graduates
            FROM 
                grp2_user use1
            JOIN 
                grp2_training tra ON tra.TRAIN_ID = use1.TRAIN_ID
            JOIN 
                report rep ON rep.USER_ID = use1.USER_ID
            JOIN 
                grp2_year yea ON yea.ANNU_YEAR = rep.ANNU_YEAR
            JOIN 
                to_date tod ON tod.CLUB_ID = rep.CLUB_ID AND tod.ANNU_YEAR = yea.ANNU_YEAR
            JOIN 
                grp2_club clu ON clu.CLUB_ID = rep.CLUB_ID
            GROUP BY 
                yea.ANNU_YEAR, tra.TRAIN_ID
            ORDER BY 
                yea.ANNU_YEAR, tra.TRAIN_ID
        ");

        return view('trainingGraph', ['data' => $data]);
    }
}
?>
