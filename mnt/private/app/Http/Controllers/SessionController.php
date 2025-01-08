<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;

class SessionController extends Controller
{
    /**
     * Affiche le formulaire de création d'une séance.
     */
    public function create()
    {
        // Récupérer les utilisateurs liés à une formation
        $users = User::select('USER_ID', 'USER_FIRSTNAME', 'USER_LASTNAME')
            ->where('LEVEL_ID_RESUME', '=', session('level_id_resume'))
            ->where('TYPE_ID', '=', 1)
            ->where('USER_ID', '!=', session('user_id'))
            ->distinct()
            ->get();

        // Liste des aptitudes
        $aptitudes = Ability::select('Abi_label')
        ->join('grp2_skill', 'grp2_skill.skill_id', '=', 'GRP2_ABILITY.skill_id')
        ->where('grp2_skill.level_id', '=', session('level_id_resume'))
        ->get();
        /*$aptitudes = [
            1 => 'A1 : s\'équilibrer',
            2 => 'A2 : Respecter le millieu',
            3 => 'A3 : S\'immerger'
        ];*/

        // Liste des initiateurs
        $initiators = User::select('USER_FIRSTNAME', 'USER_LASTNAME')
        ->where('LEVEL_ID_RESUME', '=', session('level_id_resume'))
            ->where('TYPE_ID', '=', 2)
            ->where('USER_ID', '!=', session('user_id'))
            ->distinct()
            ->get();
        /*$initiators = [
            1 => 'Catherine Laroche',
            2 => 'Pierre Cailloux',
            3 => 'Jo Laucéan'
        ];*/

        // Retourner la vue avec les données
        return view('SessionCreate', compact('users', 'aptitudes', 'initiators'));
    }

    /**
     * Enregistre une nouvelle séance.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'date' => 'required|date', // Vérifie que la date est valide
            'time' => 'required|date_format:H:i', // Vérifie que l'heure est au format HH:MM
            'user_id' => 'required|exists:GRP2_USER,USER_ID', // Vérifie que l'utilisateur existe
            'aptitude_id' => 'required|integer', // Vérifie que l'aptitude est sélectionnée
            'initiator_id' => 'required|integer', // Vérifie que l'initiateur est sélectionné
        ]);

        // Enregistrer la nouvelle séance dans la table GRP2_SESSION
        DB::table('GRP2_SESSION')->insert([
            'SESSION_DATE' => $validated['date'],
            'SESSION_TIME' => $validated['time'],
            'USER_ID' => $validated['user_id'],
            'APTITUDE_ID' => $validated['aptitude_id'],
            'INITIATOR_ID' => $validated['initiator_id'],
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('sessions.create')->with('success', 'Séance créée avec succès !');
    }
}
