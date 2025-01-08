<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function updateEvaluation(Request $request)
{
    
    $evalId = $request->input('eval_id');
    $statutId = $request->input('statut_id');
    $user_id = $request->input('user_id');
    $abi_id = $request->input('abi_id');
    $sess_id = $request->input('sess_id');

    if($evalId == 0){
        $evalId = Evaluation::count()+1;
    }

    DB::table('grp2_evaluation')->updateOrInsert(
        ['EVAL_ID' => $evalId],
        [
            'STATUSTYPE_ID' => $statutId,
            'USER_ID' => $user_id,
            'SESS_ID' => $sess_id,
            'ABI_ID' => $abi_id
        ]
    );
    

        

    return response()->json(['message' => 'Nouvelle évaluation créée avec succès!']);
}

}
