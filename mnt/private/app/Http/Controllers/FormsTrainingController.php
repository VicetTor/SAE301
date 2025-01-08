<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Level;
use App\Models\typeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class FormsTrainingController extends Controller
{

    public function show() {
        $trainings = DB::table('grp2_user')
        ->where('type_id','=','3')
        ->get();

        $studies = DB::table('grp2_user')
        ->where('type_id','=','4')
        ->get();

        $trainDatas = DB::table('grp2_training')
        ->get();


        return view('FormsTraining',['trainings'=>$trainings, 'studies'=>$studies, 'trainDatas'=>$trainDatas]);
    }

    public function validateForms(Request $request) {
        // Déboguer la requête entière pour voir si 'initiators' et 'students' existent
        
    
        // Récupérer les initiateurs et étudiants
        $initiators = $request->input('initiators', []);
        $students = $request->input('students', []);
        $formationId = $request->input('formation_id');
    
        // Vérifier que 'initiators' et 'students' sont bien des tableaux
        
    
        // Boucle pour les initiateurs
        foreach ($initiators as $initiatorId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $initiatorId)
                ->update(['TRAIN_ID' => $request->TRAIN_ID]);
        }
    
        // Boucle pour les étudiants
        foreach ($students as $studentId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $studentId)
                ->update(['TRAIN_ID' => $request->TRAIN_ID]);
        }
    
        // Retour avec succès
        return redirect()->back()->with('success', 'Les initiateurs et étudiants ont été mis à jour avec succès!');
    }    

}
