<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SessionDelete extends Controller
{
    public function destroy($id)
    {

         // Supprimer d'abord les enregistrements associés dans la table GRP2_ATTENDEE
        DB::table('GRP2_ATTENDEE')->where('SESS_ID', $id)->delete();

        // Trouver les évaluations associées à la session et les supprimer
        DB::table('GRP2_EVALUATION')->where('SESS_ID', $id)->delete();
    
        // Trouver la session à supprimer
        $session = Session::findOrFail($id);
    
        // Supprimer la session
        $session->delete();
    
        // Rediriger avec un message de succès
        return redirect()->route('session.view');

    }
    

}
