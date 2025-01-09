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
use Illuminate\Support\Facades\Session;

class FormsTrainingController extends Controller {
    public function show() {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }

        $trainings = DB::table('grp2_user')
        ->where('type_id','=','2')
        ->where('train_id', '=', '0')
        ->get();

        $trainDatas = DB::table('grp2_training')
        ->where('train_id', '!=', 0)

        ->get();

        $canEdit = session('type_id') == 4;

        if($canEdit) {
            return view('FormsTraining',['trainings'=>$trainings, 'trainDatas'=>$trainDatas]);
        } else {
            return view('Home');
        }
    }

    public function validateForms(Request $request) {
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        DB::update('update grp2_user set type_id = ? where user_id = ?', [3, $request->TRAIN_RESPONSABLE_ID]);

        DB::update('update grp2_user set train_id = ? where user_id = ?', [$request->TRAIN_ID, $request->TRAIN_RESPONSABLE_ID]);

        return redirect()->back()->with('success', 'L\'initiateur est bien devenue responsable!');
    }

    public function showTrainingHome() {
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        return view('TrainingHome');
    }

    public function showUpdateTrainingAdd() {
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }

        $students = DB::table('grp2_user')
        ->where('type_id','=','2')
        ->where('train_id', '=', '0')
        ->get();

        $studies = DB::table('grp2_user')
        ->where('type_id','=','1')
        ->where('train_id', '=', '0')
        ->get();

        return view('FormsModificationAdd',['trainings' =>  $students,'studies' => $studies]);
    }

    public function showUpdateTrainingRemove() {
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $students = DB::table('grp2_user')
        ->where('type_id','=','2')
        ->where('train_id', '=', session('train_id'))
        ->get();

        $studies = DB::table('grp2_user')
        ->where('type_id','=','1')
        ->where('train_id', '=', session('train_id'))
        ->get();

        return view('FormsModificationRemove',['trainings' =>  $students,'studies' => $studies]);
    }


    public function UpdateTraining(Request $request){
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $students = $request->input('students', []);
        $initiators = $request->input('initiators', []);

        // Récupérer les initiateurs et étudiants
        $formationId = $request->input('formation_id');

        // Calculer le nombre maximum d'élèves autorisés
        $maxStudents = count($initiators) * 2;

        // Vérifier que le nombre d'étudiants ne dépasse pas le maximum autorisé
        if (count($students) > $maxStudents) {
            return redirect()->back()->withErrors(['students' => 'Le nombre d\'étudiants sélectionnés dépasse le maximum autorisé en fonction du nombre d\'initiateurs.']);
        }

        // Boucle pour les initiateurs
        foreach ($initiators as $initiatorId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $initiatorId)
                ->update(['TRAIN_ID' => session('train_id')]);
        }

        // Boucle pour les étudiants
        foreach ($students as $studentId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $studentId)
                ->update(['TRAIN_ID' => session('train_id')]);
        }

        // Retour avec succès
        return view('TrainingHome');
    }

    public function RemoveTraining(Request $request){
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $students = $request->input('students', []);
        $initiators = $request->input('initiators', []);

        // Récupérer les initiateurs et étudiants
        $formationId = $request->input('formation_id');

        // Boucle pour les initiateurs
        foreach ($initiators as $initiatorId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $initiatorId)
                ->update(['TRAIN_ID' => 0]);
        }

        // Boucle pour les étudiants
        foreach ($students as $studentId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $studentId)
                ->update(['TRAIN_ID' => 0]);
        }

        // Retour avec succès
        return view('TrainingHome');
    }

    public function showModificationTechnical() {
        if (session('user_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $abilities = DB::table('grp2_ability')
        ->get();
        return view('TrainingModificationTechnical', ['abilities'=>$abilities]);
    }
    public function UpdateAbilities(Request $request) {

        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        DB::table('grp2_ability')
            ->where('abi_id', '=', $request->abilitie_id)
            ->update(['abi_label' => $request->new_abilitie_id]);
        // Retour avec succès
        return view('TrainingHome');
    }
}
