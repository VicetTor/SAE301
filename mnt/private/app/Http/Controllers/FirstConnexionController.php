<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FirstConnexionController extends Controller
{
    public function show(Request $request){

        $utilisateurId = $request->query('utilisateur');
        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        return view('FirstConnexion', ['utilisateur' => $utilisateur]);
    }


    public function fill(Request $request){

        $utilisateurId = $request->query('utilisateur');

        $utilisateur = DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->first();

        $newPassword = $request->input('USER_PASSWORD');

        if (!$newPassword) {
            return view('FirstConnexion', ['utilisateur' => $utilisateur]);
        }

        DB::table('grp2_user')
            ->where('grp2_user.user_id', '=', $utilisateurId)
            ->update(['grp2_user.user_password' => Hash::make($newPassword), 'grp2_user.user_isfirstlogin' => 0]);

        return redirect()->route('connexion');

    }


}
