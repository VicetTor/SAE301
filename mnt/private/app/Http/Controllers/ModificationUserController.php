<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB ;

class ModificationUserController extends Controller {

    // Affiche la page avec tous les utilisateurs
    public function show() {

        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $club = DB::table('report')
        ->where('report.user_id' , '=', Session('user_id'))
        ->first();
        

        $users = User::where('USER_ISACTIVE', 1)
                    ->join('report' , 'report.user_id', '=','grp2_user.user_id')
                      ->where('TYPE_ID', '!=', 4)
                      ->where('CLUB_ID', '=', $club->CLUB_ID)
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
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

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
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        
        $user = User::find($id); 
        return view('EditUser', ['user' => $user]);
    }

    // Met à jour les informations d'un utilisateur
    public function update(Request $request, $id) {
       
        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
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
        if (session('type_id') != 4) {
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