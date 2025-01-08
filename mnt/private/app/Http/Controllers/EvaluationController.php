<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Club;
use App\Models\Evaluation;
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
    public function historiqueEvaluations($userId, $clubId)
    {
        // Récupérer l'utilisateur et le club
        $user = User::find($userId);
        $club = Club::find($clubId);

        // Vérifier si l'utilisateur et le club existent
        if (!$user || !$club) {
            return response()->json(['message' => 'Utilisateur ou club non trouvé.'], 404);
        }

        // Récupérer les rapports de l'utilisateur pour le club spécifié
        $report = $user->reports()
            ->where('CLUB_ID', $clubId)
            ->first();

        // Si aucun rapport n'est trouvé
        if (!$report) {
            return response()->json(['message' => 'Aucun rapport trouvé pour cet utilisateur dans ce club.'], 404);
        }

        // Récupérer les évaluations de l'utilisateur pour le club spécifié
        $evaluations = $user->evaluations()
            ->whereHas('report', function ($query) use ($clubId) {
                $query->where('CLUB_ID', $clubId);
            })
            ->get();

        // Si aucune évaluation n'est trouvée
        if ($evaluations->isEmpty()) {
            return response()->json(['message' => 'Aucune évaluation trouvée pour cet utilisateur dans ce club.'], 404);
        }

        return response()->json($evaluations);
    }

    public function search(Request $request) {
        $searchTerm = $request->input('search');
        $userId = $request->input('userId');
        $clubId = $request->input('clubId');
        
        // Construire la requête pour filtrer les évaluations
        $evaluationsQuery = Evaluation::query()
            ->with(['user', 'club', 'level', 'skill']) // Assure-toi de charger les relations
            ->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('USER_FIRSTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LASTNAME', 'like', '%' . $searchTerm . '%')
                        ->orWhere('USER_LICENSENUMBER', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('club', function ($query) use ($searchTerm) {
                    $query->where('CLUB_NAME', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('level', function ($query) use ($searchTerm) {
                    $query->where('LEVEL_LABEL', 'like', '%' . $searchTerm . '%');
                })
                ->orWhereHas('skill', function ($query) use ($searchTerm) {
                    $query->where('Skill_Label', 'like', '%' . $searchTerm . '%');
                });
            });
    
        // Si un userId est passé, ajouter un filtre
        if ($userId) {
            $evaluationsQuery->where('USER_ID', $userId);
        }
    
        // Si un clubId est passé, ajouter un filtre
        if ($clubId) {
            $evaluationsQuery->whereHas('club', function ($query) use ($clubId) {
                $query->where('club_id', $clubId);
            });
        }
    
        // Exécuter la requête et récupérer les résultats
        $evaluations = $evaluationsQuery->get();
    
        // Vérifier si un skill existe pour chaque évaluation
        foreach ($evaluations as $evaluation) {
            if (!$evaluation->skill) {
                // Si pas de skill, tu peux mettre un message ou une valeur par défaut
                $evaluation->skill_label = 'Pas de compétence associée';
            } else {
                $evaluation->skill_label = $evaluation->skill->Skill_Label;
            }
        }
    
        // Retourner les évaluations à la vue
        return view('EvaluationHistory', compact('evaluations'));
    }    
}
?>