<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Schema(
 *     schema="Training",
 *     type="object",
 *     required={"TRAIN_ID", "title", "description", "responsable_id"},
 *     @OA\Property(property="id", type="integer", description="Training ID"),
 *     @OA\Property(property="TRAIN_ID", type="integer", description="Training Unique ID"),
 *     @OA\Property(property="title", type="string", description="Training Title"),
 *     @OA\Property(property="description", type="string", description="Training Description"),
 *     @OA\Property(property="responsable_id", type="integer", description="Responsible User ID"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Creation Timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Update Timestamp")
 * )
 */

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
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $trainings = Training::all(); // Retrieves all training records from the database.
        return response()->json($trainings); // Returns a JSON response containing the list of trainings.
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
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $training = Training::find($id); // Finds a specific training by its ID.

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404); // If not found, returns an error response.
        }

        return response()->json($training); // Returns the found training as a JSON response.
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
     *             required={"TRAIN_ID", "title", "description", "responsable_id"},
     *             @OA\Property(property="TRAIN_ID", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="responsable_id", type="integer")
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
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        // Validating input data.
        $validated = $request->validate([
            'TRAIN_ID' => 'required|integer', // Ensures the TRAIN_ID is an integer.
            'title' => 'required|string|max:255', // Ensures the title is a string and has a maximum length of 255 characters.
            'description' => 'nullable|string', // Description is optional.
            'responsable_id' => 'required|exists:users,id', // Ensures the responsible user exists in the database.
        ]);

        // Creating a new training record with the validated data.
        $training = Training::create([
            'TRAIN_ID' => $validated['TRAIN_ID'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'responsable_id' => $validated['responsable_id']
        ]);

        return response()->json($training, 201); // Returns the created training and a "201 Created" HTTP status.
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
     *             required={"TRAIN_ID", "title", "description", "responsable_id"},
     *             @OA\Property(property="TRAIN_ID", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="responsable_id", type="integer")
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
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $training = Training::find($id); // Finds a training record by ID.

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404); // Returns an error response if the training is not found.
        }

        // Validates the input data for updating the training.
        $validated = $request->validate([
            'TRAIN_ID' => 'required|integer', // Ensures TRAIN_ID is an integer.
            'title' => 'required|string|max:255', // Ensures the title is a string and has a maximum length of 255 characters.
            'description' => 'nullable|string', // Description is optional.
            'responsable_id' => 'required|exists:users,id', // Ensures the responsible user exists in the database.
        ]);

        $training->update($validated); // Updates the training record with validated data.

        return response()->json($training); // Returns the updated training as a JSON response.
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
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $training = Training::find($id); // Finds the training to be deleted.

        if (!$training) {
            return response()->json(['error' => 'Training not found'], 404); // Returns an error response if not found.
        }

        $training->delete(); // Deletes the found training record.

        return response()->json(['message' => 'Training deleted successfully']); // Returns a success message.
    }

    // Display the form to select the year for data export
    public function showYearSelectionForm() {
        if (session('type_id') == 3) {
            return redirect()->route('home');
        }
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        // Retrieves the available years from the database.
        $years = DB::table('grp2_year')->pluck('ANNU_YEAR');

        return view('selectYear', ['years' => $years]); // Returns a view with the available years for selection.
    }

    // Handles the year selection form submission
    public function handleYearSelection(Request $request) {
        if (session('type_id') == 3) {
            return redirect()->route('home');
        }
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $year = $request->input('year'); // Gets the selected year from the form.

        // Redirects to the data export route with the selected year.
        return redirect()->route('exportTrainingData', ['year' => $year]);
    }

    // Exports training data to a CSV file for a specific year
    public function exportTrainingData(Request $request)
    {
        if (session('type_id') == 3) {
            return redirect()->route('home');
        }
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $year = $request->query('year'); // Gets the year parameter from the query string.

        $callback = function() use ($year) {
            $handle = fopen('php://output', 'w'); // Opens the output stream for writing CSV data.

            // Writes the column headers for the CSV.
            fputcsv($handle, ['Training ID', 'Number of registrations in the club', 'Number of graduates', 'Year']);

            // Executes the SQL query to retrieve the training data for the selected year.
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

            // Loops through the results and writes each row to the CSV.
            foreach ($results as $row) {
                fputcsv($handle, (array)$row);
            }

            fclose($handle); // Closes the output stream.
        };

        // Sets the response headers to prompt the user to download the CSV.
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="training_data_'.$year.'.csv"',
        ];

        return response()->stream($callback, 200, $headers); // Streams the CSV content for download.
    }

    // Displays a graph showing training data for all years
    public function showTrainingGraph() {
        if (session('type_id') == 1) {
            return redirect()->route('home');
        }
        if (session('type_id') == 3) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        // Executes the SQL query to retrieve aggregated training data for all years.
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

        return view('trainingGraph', ['data' => $data]); // Returns a view to display the graph with the training data.
    }
}
