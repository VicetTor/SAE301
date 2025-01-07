<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    /**
     * Affiche le formulaire de création d'une séance.
     */
    public function create()
    {
        // Récupérer les utilisateurs liés à une formation
        $users = DB::table('GRP2_USER as u')
            ->join('GRP2_ATTENDEE as a', 'u.USER_ID', '=', 'a.LATTD_ID')
            ->join('GRP2_SESSION as s', 'a.GR2P_SESSION_ID', '=', 's.GR2P_SESSION_ID')
            ->join('GRP2_TRAINING as t', 's.TRAIN_ID', '=', 't.TRAIN_ID')
            ->select('u.USER_ID', 'u.USER_FIRSTNAME', 'u.USER_LASTNAME', 't.TRAIN_LABEL')
            ->distinct()
            ->get();

        // Liste des aptitudes
        $aptitudes = [
            1 => 'A1 : s\'équilibrer',
            2 => 'A2 : Respecter le millieu',
            3 => 'A3 : S\'immerger'
        ];

        // Liste des initiateurs
        $initiators = [
            1 => 'Catherine Laroche',
            2 => 'Pierre Cailloux',
            3 => 'Jo Laucéan'
        ];

        // Retourner la vue avec les données
        return view('createSession', compact('users', 'aptitudes', 'initiators'));
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
            'created_at' => now(), // Timestamp automatique
            'updated_at' => now(), // Timestamp automatique
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('sessions.create')->with('success', 'Séance créée avec succès !');
    }
}
