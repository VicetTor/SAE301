<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Evaluation;
use App\Models\Session;

class CommentaireController extends Controller
{
    public function commentaireEval(Request $request)
{
    $evalId = $request->input('eval_id');
    $statutId = $request->input('statut_id');
    $user_id = $request->input('user_id');
    $abi_id = $request->input('abi_id');
    $sess_id = $request->input('sess_id');

    $evaluation = Evaluation::find($evalId);
    $session = Session::find($sess_id);

    if($session->SESS_DATE < now() || Session('type_id') != 2){
        $txtReadOnly="readonly";
    }else{
        $txtReadOnly="";
    }

    $pop = '
    <div class="popup-content border border-primary border border-4">
    
        <span class="popup-close">&times;</span>
        <p class="fw-medium fs-3">Observation de la séance</p>
        <hr></hr>
        <div id="popup-body">
            <label for="popup-comment" class="fst-italic fs-6 mb-2">commentaire :</label>
            <textarea class="popup-comment rounded-4" rows="4" cols="40" '.$txtReadOnly.'>'.$evaluation->EVAL_OBSERVATION.'</textarea>
            <button class="popup-submit btn btn-success mt-3 mb-3 btn-lg" data-eval-id="'.$evalId.'">Valider</button> 
        </div>
    </div>'
    ;


    return response()->json(['html' => $pop]);
}

public function updateCommentaire(Request $request)
{
    Log::info('Requête reçue : ', $request->all());

    $eval_id = $request->input('eval_id');
    $contenu = $request->input('contenu');

    $evaluation = Evaluation::find($eval_id);

    if ($evaluation) {
        $evaluation->EVAL_OBSERVATION = $contenu;
        $evaluation->save();

        Log::info('Évaluation mise à jour : ', $evaluation->toArray());

        return response()->json([
            'status' => 'success',
            'message' => 'oui.',
        ]);
    }

    Log::warning('Évaluation introuvable pour ID : ' . $eval_id);

    return response()->json([
        'status' => 'error',
        'message' => 'Évaluation introuvable.',
    ], 404);
}


}
