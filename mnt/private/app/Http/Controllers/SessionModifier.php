<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;

class SessionModifier extends Controller
{
    /**
     * Affiche le formulaire de création d'une séance.
     */
    // Méthode pour afficher le formulaire de modification d'une session
    public function edit($id)
    {
    // Récupérer la session à modifier
    $session = Session::findOrFail($id);

    // Retourner la vue de modification avec la session
    return view('sessions.edit', compact('session'));
}

}
