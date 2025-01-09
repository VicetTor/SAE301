<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FormsTrainingController extends Controller
{
    /**
     * Show the training forms page with necessary data.
     *
     * @return \Illuminate\View\View Rendered view of the FormsTraining page or Home page.
     */
    public function show() {
        // Retrieve all trainers (users with type_id = 3)
        $trainings = DB::table('grp2_user')
            ->where('type_id', '=', '3')
            ->get();

        // Retrieve all students (users with type_id = 4)
        $studies = DB::table('grp2_user')
            ->where('type_id', '=', '4')
            ->get();

        // Retrieve all training data
        $trainDatas = DB::table('grp2_training')->get();

        // Retrieve all levels
        $levelIds = DB::table('grp2_level')->get();

        // Check if the current user has permissions to edit (type_id = 4)
        $canEdit = session('type_id') == 4;

        // Render FormsTraining view if the user has permission, otherwise redirect to Home
        if ($canEdit) {
            return view('FormsTraining', [
                'trainings' => $trainings, 
                'studies' => $studies, 
                'trainDatas' => $trainDatas, 
                'levelIds' => $levelIds
            ]);
        } else {
            return view('Home');
        }
    }

    /**
     * Validate and process the training forms data for trainers and students.
     *
     * @param  Request  $request  Incoming request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirect back with success or error messages.
     */
    public function validateForms(Request $request) {
        // Validate the input fields
        $request->validate([
            'TRAIN_RESPONSABLE_ID' => 'required|exists:grp2_user,USER_ID', // Responsible trainer must exist
            'TRAIN_ID' => 'required|exists:grp2_training,TRAIN_ID', // Training ID must exist
            'initiators' => 'required|array|min:1', // At least one initiator is required
            'students' => 'required|array|min:1' // At least one student is required
        ], [
            // Custom error messages
            'TRAIN_RESPONSABLE_ID.required' => 'The responsible field is mandatory.',
            'TRAIN_RESPONSABLE_ID.exists' => 'The selected responsible is invalid.',
            'TRAIN_ID.required' => 'The level field is mandatory.',
            'TRAIN_ID.exists' => 'The selected level is invalid.',
            'initiators.required' => 'The initiators field is mandatory.',
            'initiators.array' => 'The initiators field must be an array.',
            'initiators.min' => 'You must select at least one initiator.',
            'students.required' => 'The students field is mandatory.',
            'students.array' => 'The students field must be an array.',
            'students.min' => 'You must select at least one student.'
        ]);

        // Retrieve initiators and students from the request
        $initiators = $request->input('initiators', []);
        $students = $request->input('students', []);
        
        // Maximum number of students allowed is twice the number of initiators
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
                ->update(['TRAIN_ID' => $request->TRAIN_ID]);
        }

        // Assign training ID to each student
        foreach ($students as $studentId) {
            DB::table('grp2_user')
                ->where('USER_ID', '=', $studentId)
                ->update(['TRAIN_ID' => $request->TRAIN_ID]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'The initiators and students have been successfully updated!');
    }

    /**
     * Validate and process the addition of new skills linked to a level.
     *
     * @param  Request  $request  Incoming request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirect back with success or error messages.
     */
    public function validateForms2(Request $request) {
        // Validate the input fields
        $request->validate([
            'LEVEL_ID' => 'required|exists:grp2_level,LEVEL_ID', // Level ID must exist
            'SKILL_LABEL' => 'required|string|max:255' // Skill label must be a valid string
        ], [
            // Custom error messages
            'LEVEL_ID.required' => 'The level field is mandatory.',
            'LEVEL_ID.exists' => 'The selected level is invalid.',
            'SKILL_LABEL.required' => 'The skill title field is mandatory.',
            'SKILL_LABEL.string' => 'The skill title must be a string.',
            'SKILL_LABEL.max' => 'The skill title must not exceed 255 characters.'
        ]);

        // Calculate the next skill ID by counting existing skills and adding 1
        $skills = DB::table('grp2_skill')->get();
        $skill_id = count($skills) + 1;

        // Insert a new skill record into the 'grp2_skill' table
        DB::table('grp2_skill')->insert([
            'SKILL_ID' => $skill_id,
            'LEVEL_ID' => $request->LEVEL_ID,
            'SKILL_LABEL' => $request->SKILL_LABEL,
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'The new skill has been successfully added!');
    }
}
