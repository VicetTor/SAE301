<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Displays the evaluation history for a given user and club.
     *
     * @param  int  $userId  The ID of the user.
     * @param  int  $clubId  The ID of the club.
     * @return \Illuminate\Http\Response
     */
    public function historiqueEvaluations($userId, $clubId) {
        // Retrieve the user and the club by their IDs
        $user = User::find($userId);
        $club = Club::find($clubId);
    
        // Check if the user and the club exist
        if (!$user || !$club) {
            return response()->json(['message' => 'User or club not found.'], 404);
        }
    
        // Retrieve the evaluations for the specified user and club
        $evaluations = Evaluation::with(['user', 'validation.level', 'validation.skill'])
            ->where('USER_ID', $userId)
            ->whereHas('user.reports', function ($query) use ($clubId) {
                // Filter evaluations based on reports associated with the specified club
                $query->where('CLUB_ID', $clubId);
            })
            ->get();
    
        // If no evaluations are found, return a 404 response
        if ($evaluations->isEmpty()) {
            return response()->json(['message' => 'No evaluations found for this user in this club.'], 404);
        }
    
        // Check if the current session user has editing privileges
        $canEdit = session('type_id') == 4 || session('type_id') == 3;

        // Render the appropriate view based on user privileges
        if ($canEdit) {
            return view('EvaluationHistory', compact('evaluations'));
        } else {
            return view('Home');
        }
    }

    /**
     * Search for evaluations based on various filters.
     *
     * @param  Request  $request  The HTTP request object.
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        // Retrieve the search term and optional user/club filters from the request
        $searchTerm = $request->input('search');
        $userId = $request->input('userId');
        $clubId = $request->input('clubId');       
    
        // Build the query to filter evaluations
        $evaluationsQuery = Evaluation::query()
            ->with(['user', 'validation.level', 'validation.skill', 'user.reports']) // Load related data
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($query) use ($searchTerm) {
                    // Search for the term in user details
                    $query->where('USER_FIRSTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LASTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LICENSENUMBER', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('user.reports.club', function ($query) use ($searchTerm) {
                    // Search for the term in club details
                    $query->where('CLUB_NAME', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('validation.level', function ($query) use ($searchTerm) {
                    // Search for the term in level details
                    $query->where('LEVEL_LABEL', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('validation.skill', function ($query) use ($searchTerm) {
                    // Search for the term in skill details
                    $query->where('SKILL_LABEL', 'like', '%' . $searchTerm . '%');
                });
            });
    
        // Apply user ID filter if provided
        if ($userId) {
            $evaluationsQuery->where('USER_ID', $userId);
        }
    
        // Apply club ID filter if provided
        if ($clubId) {
            $evaluationsQuery->whereHas('user.reports', function ($query) use ($clubId) {
                $query->where('CLUB_ID', $clubId);
            });
        }
    
        // Execute the query and retrieve the results
        $evaluations = $evaluationsQuery->get();

        // Check if the current session user has editing privileges
        $canEdit = session('type_id') == 4 || session('type_id') == 3;

        // Render the appropriate view based on user privileges
        if ($canEdit) {
            return view('EvaluationHistory', compact('evaluations'));
        } else {
            return view('Home');
        }
    }


    public function updateEvaluation(Request $request)
    {
        
        $evalId = $request->input('eval_id');
        $statutId = $request->input('statut_id');
        $user_id = $request->input('user_id');
        $abi_id = $request->input('abi_id');
        $sess_id = $request->input('sess_id');
    
        if($evalId == 0){
            $evalId = Evaluation::count()+1;
        }
    
        DB::table('grp2_evaluation')->updateOrInsert(
            ['EVAL_ID' => $evalId],
            [
                'STATUSTYPE_ID' => $statutId,
                'USER_ID' => $user_id,
                'SESS_ID' => $sess_id,
                'ABI_ID' => $abi_id
            ]
        );
        
    
            
    
        return response()->json(['message' => 'Nouvelle évaluation créée avec succès!']);
    }
    
    


}
?>
