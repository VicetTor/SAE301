<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ModificationUserController extends Controller {

    // Drapeau pour activer/désactiver la simulation
    private $simulate = false;

    // Simule un utilisateur authentifié pour les tests
    private function simulateAuthenticatedUser() {
        if ($this->simulate && !Auth::check()) {
            $user = new User();
            $user->USER_ID = 9999; // ID fictif pour l'utilisateur simulé
            $user->USER_FIRSTNAME = 'Test';
            $user->USER_LASTNAME = 'User';
            $user->USER_MAIL = 'test@example.com';
            $user->USER_PASSWORD = bcrypt('password'); // Mot de passe fictif
            $user->TYPE_ID = 4; // TYPE_ID = 4 pour les tests
            $user->USER_ISACTIVE = 1;

            // Authentifier l'utilisateur fictif
            Auth::login($user);
        }
    }

    // Affiche la page avec tous les utilisateurs
    public function show() {
        $this->simulateAuthenticatedUser();  // Simuler l'utilisateur authentifié

        $users = User::where('USER_ISACTIVE', 1)
                      ->where('TYPE_ID', '!=', 1)
                      ->get();
        
        $canEdit = session('type_id') == 4; 

        if($canEdit) {
            return view('ModificationUser', ['users' => $users, 'canEdit' => $canEdit]);
        } else  {
            return view('Home');
        }
    }

    // Recherche les utilisateurs par nom ou numéro de licence
    public function search(Request $request) {
        $this->simulateAuthenticatedUser();  // Simuler l'utilisateur authentifié

        $searchTerm = $request->input('search');
        $users = User::where('USER_FIRSTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LASTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LICENSENUMBER', 'LIKE', "%$searchTerm%")
                    ->get();
        
        $canEdit = Auth::check() && Auth::user()->TYPE_ID == 4; 

        return view('ModificationUser', ['users' => $users, 'canEdit' => $canEdit]);
    }

    // Affiche la page pour modifier un utilisateur
    public function edit($id) {
        $this->simulateAuthenticatedUser();  // Simuler l'utilisateur authentifié

        if (!(Auth::check() && Auth::user()->TYPE_ID == 4)) {
            return redirect()->route('modification.users')->with('error', 'Vous n\'êtes pas autorisé à modifier des utilisateurs.');
        }
        
        $user = User::find($id); 
        return view('EditUser', ['user' => $user]);
    }

    // Met à jour les informations d'un utilisateur
    public function update(Request $request, $id) {
        $this->simulateAuthenticatedUser();  // Simuler l'utilisateur authentifié

        if (!(Auth::check() && Auth::user()->TYPE_ID == 4)) {
            return redirect()->route('modification.users')->with('error', 'Vous n\'êtes pas autorisé à modifier des utilisateurs.');
        }

        $user = User::find($id); 
        if ($user) {
            $user->USER_FIRSTNAME = $request->input('USER_FIRSTNAME');
            $user->USER_LASTNAME = $request->input('USER_LASTNAME');
            $user->USER_LICENSENUMBER = $request->input('USER_LICENSENUMBER');
            $user->USER_MAIL = $request->input('USER_MAIL');
            $user->USER_PHONENUMBER = $request->input('USER_PHONENUMBER');
            $user->USER_ADDRESS = $request->input('USER_ADDRESS');
            $user->USER_POSTALCODE = $request->input('USER_POSTALCODE');
            $user->TYPE_ID = $request->input('TYPE_ID');
            $user->LEVEL_ID_RESUME = $request->input('LEVEL_ID_RESUME');
            $user->USER_MEDICCERTIFICATEDATE = $request->input('USER_MEDICCERTIFICATEDATE');
            $user->save();
        }
        return redirect()->route('modification.users')->with('success', 'Les informations de l\'utilisateur ont été mises à jour avec succès.');
    }

    // Supprime un utilisateur (en désactivant le champ USER_ISACTIVE)
    public function delete($id) {
        $this->simulateAuthenticatedUser();  // Simuler l'utilisateur authentifié

        if (!(Auth::check() && Auth::user()->TYPE_ID == 4)) {
            return redirect()->route('modification.users')->with('error', 'Vous n\'êtes pas autorisé à supprimer des utilisateurs.');
        }

        $user = User::find($id);
        if ($user) {
            $user->USER_ISACTIVE = 0; // Désactive l'utilisateur
            $user->save(); // Sauvegarde les changements
        }
        return redirect()->route('modification.users')->with('success', 'L\'utilisateur a été désactivé avec succès.');
    }
}
?>