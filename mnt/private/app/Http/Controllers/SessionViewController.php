<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Models\Ability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\models\Session;

use App\Models\User;
use App\Models\Report;
use Ramsey\Uuid\Type\Integer;

class SessionViewController extends Controller
{
    /**
     * Affiche le formulaire de création d'une séance.
     */
    public function create()
    {
        
        $sessions = Session::select('SESS_ID', 'TRAIN_ID', 'SESS_DATE')
            ->where('TRAIN_ID', '=', session('level_id_resume'))
            ->get();
            @dd($sessions);
        

        // Retourner la vue avec les données
        return view('SessionsPage', compact('sessions'));
    }
}
