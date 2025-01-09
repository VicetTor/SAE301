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

        $levelIds = DB::table('grp2_level')
        ->get();


        return view('FormsTraining',['trainings'=>$trainings, 'studies'=>$studies, 'trainDatas'=>$trainDatas, 'levelIds'=>$levelIds]);
    }

    public function validateForms(Request $request) {
        // Valider les entrées
        $request->validate([
            'TRAIN_RESPONSABLE_ID' => 'required|exists:grp2_user,USER_ID',
            'TRAIN_ID' => 'required|exists:grp2_training,TRAIN_ID',
            'initiators' => 'required|array|min:1',
            'students' => 'required|array|min:1'
        ], [
            'TRAIN_RESPONSABLE_ID.required' => 'Le champ responsable est obligatoire.',
            'TRAIN_RESPONSABLE_ID.exists' => 'Le responsable sélectionné est invalide.',
            'TRAIN_ID.required' => 'Le champ niveau est obligatoire.',
            'TRAIN_ID.exists' => 'Le niveau sélectionné est invalide.',
            'initiators.required' => 'Le champ initiateurs est obligatoire.',
            'initiators.array' => 'Le champ initiateurs doit être un tableau.',
            'initiators.min' => 'Vous devez sélectionner au moins un initiateur.',
            'students.required' => 'Le champ élèves est obligatoire.',
            'students.array' => 'Le champ élèves doit être un tableau.',
            'students.min' => 'Vous devez sélectionner au moins un élève.'
        ]);
    
        // Récupérer les initiateurs et étudiants
        $initiators = $request->input('initiators', []);
        $students = $request->input('students', []);
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
    
    public function validateForms2(Request $request) {
        // Valider les entrées
        $request->validate([
            'LEVEL_ID' => 'required|exists:grp2_level,LEVEL_ID',
            'SKILL_LABEL' => 'required|string|max:255'
        ], [
            'LEVEL_ID.required' => 'Le champ niveau est obligatoire.',
            'LEVEL_ID.exists' => 'Le niveau sélectionné est invalide.',
            'SKILL_LABEL.required' => 'Le champ titre de la compétence est obligatoire.',
            'SKILL_LABEL.string' => 'Le titre de la compétence doit être une chaîne de caractères.',
            'SKILL_LABEL.max' => 'Le titre de la compétence ne doit pas dépasser 255 caractères.'
        ]);
    
        // On regarde le nombre de skills qu'il y a et on rajoute plus un au nombre de skills pour le skill_id
        $skills = DB::table('grp2_skill')->get();
        $skill_id = count($skills) + 1;
    
        // Insérer une donnée dans la table grp2_skill
        DB::table('grp2_skill')->insert([
            'SKILL_ID' => $skill_id,
            'LEVEL_ID' => $request->LEVEL_ID,
            'SKILL_LABEL' => $request->SKILL_LABEL,
        ]);
    
        // Retour avec succès
        return redirect()->back()->with('success', 'L\'ajout d\'une compétence a été effectué avec succès!');
    }
}
