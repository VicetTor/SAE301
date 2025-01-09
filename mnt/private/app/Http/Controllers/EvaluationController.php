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
     * Affiche l'historique des évaluations pour un utilisateur et un club donnés.
     *
     * @param  int  $userId
     * @param  int  $clubId
     * @return \Illuminate\Http\Response
     */
    public function historiqueEvaluations($userId, $clubId) {
        // Récupérer l'utilisateur et le club
        $user = User::find($userId);
        $club = Club::find($clubId);
    
        // Vérifier si l'utilisateur et le club existent
        if (!$user || !$club) {
            return response()->json(['message' => 'Utilisateur ou club non trouvé.'], 404);
        }
    
        // Récupérer les évaluations de l'utilisateur pour le club spécifié
        $evaluations = Evaluation::with(['user', 'validation.level', 'validation.skill'])
            ->where('USER_ID', $userId)
            ->whereHas('user.reports', function ($query) use ($clubId) {
                $query->where('CLUB_ID', $clubId);
            })
            ->get();
    
        // Si aucune évaluation n'est trouvée
        if ($evaluations->isEmpty()) {
            return response()->json(['message' => 'Aucune évaluation trouvée pour cet utilisateur dans ce club.'], 404);
        }
    
        $canEdit = session('type_id') == 4 || session('type_id') == 3;

        if($canEdit) {
            return view('EvaluationHistory', compact('evaluations'));
        } else {
            return view('Home');
        }
    }

    public function search(Request $request) {
        $searchTerm = $request->input('search');
        $userId = $request->input('userId');
        $clubId = $request->input('clubId');       
    
        // Construire la requête pour filtrer les évaluations
        $evaluationsQuery = Evaluation::query()
            ->with(['user', 'validation.level', 'validation.skill', 'user.reports']) // Charger les relations nécessaires
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('USER_FIRSTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LASTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LICENSENUMBER', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('user.reports.club', function ($query) use ($searchTerm) {
                    $query->where('CLUB_NAME', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('validation.level', function ($query) use ($searchTerm) {
                    $query->where('LEVEL_LABEL', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('validation.skill', function ($query) use ($searchTerm) {
                    $query->where('SKILL_LABEL', 'like', '%' . $searchTerm . '%');
                });
            });
    
        // Si un userId est passé, ajouter un filtre
        if ($userId) {
            $evaluationsQuery->where('USER_ID', $userId);
        }
    
        // Si un clubId est passé, ajouter un filtre
        if ($clubId) {
            $evaluationsQuery->whereHas('user.reports', function ($query) use ($clubId) {
                $query->where('CLUB_ID', $clubId);
            });
        }
    
        // Exécuter la requête et récupérer les résultats
        $evaluations = $evaluationsQuery->get();

    
        // Retourner les évaluations à la vue
        $canEdit = session('type_id') == 4 || session('type_id') == 3;

        if($canEdit) {
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