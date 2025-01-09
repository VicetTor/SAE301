<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use OpenApi\Annotations as OA;

class FormsTrainingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/forms-training",
     *     summary="Retrieve all trainers and students",
     *     tags={"Forms Training"},
     *     @OA\Response(
     *         response=200,
     *         description="Retrieved all trainers and students successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="trainings", type="array", @OA\Items(ref="#/components/schemas/User")),
     *             @OA\Property(property="studies", type="array", @OA\Items(ref="#/components/schemas/User")),
     *             @OA\Property(property="trainDatas", type="array", @OA\Items(ref="#/components/schemas/Training")),
     *             @OA\Property(property="levelIds", type="array", @OA\Items(ref="#/components/schemas/Level"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied"
     *     )
     * )
     */
    public function show() {
        // Retrieve all trainers (users with type_id = 3)
        $trainings = DB::table('grp2_user')
            ->where('type_id', '=', '3')
            ->get();

        $studies = DB::table('grp2_user')
            ->where('type_id', '=', '4')
            ->get();

        $trainDatas = DB::table('grp2_training')
            ->get();

        $levelIds = DB::table('grp2_level')
            ->get();

        // Check if the current user has permissions to edit (type_id = 4)
        $canEdit = session('type_id') == 4;

        if ($canEdit) {
            return view('FormsTraining', ['trainings' => $trainings, 'studies' => $studies, 'trainDatas' => $trainDatas, 'levelIds' => $levelIds]);
        } else {
            return view('Home');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/forms-training/validate",
     *     summary="Validate and process the training forms data for trainers and students",
     *     tags={"Forms Training"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"TRAIN_RESPONSABLE_ID", "TRAIN_ID", "initiators", "students"},
     *             @OA\Property(property="TRAIN_RESPONSABLE_ID", type="integer"),
     *             @OA\Property(property="TRAIN_ID", type="integer"),
     *             @OA\Property(property="initiators", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="students", type="array", @OA\Items(type="integer"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Training forms validated successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Les initiateurs et étudiants ont été mis à jour avec succès!"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function validateForms(Request $request) {
        // Validate the inputs
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

        // Retrieve initiators and students
        $initiators = $request->input('initiators', []);
        $students = $request->input('students', []);
        $formationId = $request->input('formation_id');

        // Calculate the maximum number of students allowed
        $maxStudents = count($initiators) * 2;

        // Check if the number of students exceeds the allowed maximum
        if (count($students) > $maxStudents) {
            return redirect()->back()->withErrors([
                'students' => 'The number of selected students exceeds the allowed maximum based on the number of initiators.'
            ]);
        }

        // Assign training ID to each initiator
        foreach ($initiators as $initiatorId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $initiatorId)
                ->update(['TRAIN_ID' => session('train_id')]);
        }

        // Assign training ID to each student
        foreach ($students as $studentId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $studentId)
                ->update(['TRAIN_ID' => session('train_id')]);
        }

        // Return with success
        return redirect()->back()->with('success', 'Les initiateurs et étudiants ont été mis à jour avec succès!');
    }

    /**
     * @OA\Post(
     *     path="/api/forms-training/validate2",
     *     summary="Validate and process the addition of a new skill",
     *     tags={"Forms Training"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"LEVEL_ID", "SKILL_LABEL"},
     *             @OA\Property(property="LEVEL_ID", type="integer"),
     *             @OA\Property(property="SKILL_LABEL", type="string", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="New skill added successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="L'ajout d'une compétence a été effectué avec succès!"))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function validateForms2(Request $request) {
        // Validate the inputs
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

    /**
     * @OA\Get(
     *     path="/api/forms-training/modification-technical",
     *     summary="Show modification technical form",
     *     tags={"Forms Training"},
     *     @OA\Response(
     *         response=200,
     *         description="Retrieved abilities successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Ability"))
     *     )
     * )
     */
    public function showModificationTechnical() {
        $abilities = DB::table('grp2_ability')->get();

        return view('TrainingModificationTechnical', ['abilities' => $abilities]);
    }

    /**
     * @OA\Post(
     *     path="/api/forms-training/update-abilities",
     *     summary="Update abilities",
     *     tags={"Forms Training"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"abilitie_id", "new_abilitie_id"},
     *             @OA\Property(property="abilitie_id", type="integer"),
     *             @OA\Property(property="new_abilitie_id", type="string", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ability updated successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Ability updated successfully"))
     *     )
     * )
     */
    public function UpdateAbilities(Request $request) {
        DB::table('grp2_ability')
            ->where('abi_id', '=', $request->abilitie_id)
            ->update(['abi_label' => $request->new_abilitie_id]);

        // Retour avec succès
        return view('TrainingHome');
    }
}