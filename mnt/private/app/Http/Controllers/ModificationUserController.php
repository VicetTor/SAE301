<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ModificationUserController extends Controller {

    // Affiche la page avec tous les utilisateurs
    public function show() {
        $users = User::where('USER_ISACTIVE', 1)
        ->where('TYPE_ID', '!=', 1)
        ->get();
        return view('ModificationUser', ['users' => $users]);
    }

    // Recherche les utilisateurs par nom ou numéro de licence
    public function search(Request $request) {
        $searchTerm = $request->input('search');
        $users = User::where('USER_FIRSTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LASTNAME', 'LIKE', "%$searchTerm%")
                    ->orWhere('USER_LICENSENUMBER', 'LIKE', "%$searchTerm%")
                    ->get();
        return view('ModificationUser', ['users' => $users]);
    }

    // Affiche la page pour modifier un utilisateur
    public function edit($id) {
        $user = User::find($id); // Trouve l'utilisateur par ID
        return view('EditUser', ['user' => $user]);
    }

    // Met à jour les informations d'un utilisateur
    public function update(Request $request, $id) {
        $user = User::find($id); // Trouve l'utilisateur par ID
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
        return redirect()->route('modification.users'); // Redirige vers la liste des utilisateurs
    }

    // Supprime un utilisateur (en désactivant le champ USER_ISACTIVE)
    public function delete($id) {
        $user = User::find($id);
        if ($user) {
            $user->USER_ISACTIVE = 0; // Désactive l'utilisateur
            $user->save(); // Sauvegarde les changements
        }
        return redirect()->route('modification.users'); // Redirige vers la liste des utilisateurs
    }
}
?>