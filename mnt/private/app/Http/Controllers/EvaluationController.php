<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evaluation;
use App\Models\Club;
use Illuminate\Http\Request;

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
    
        return view('EvaluationHistory', compact('evaluations'));
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
        return view('EvaluationHistory', compact('evaluations'));
    }
}
?>