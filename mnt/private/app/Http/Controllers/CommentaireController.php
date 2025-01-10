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
    <div class="popup-content">
    
        <span class="popup-close">&times;</span>
        <h3>Contenu de la session</h3>
        <div id="popup-body">
            <label for="popup-comment">commentaire :</label>
            <textarea class="popup-comment" rows="4" cols="50" '.$txtReadOnly.'>'.$evaluation->EVAL_OBSERVATION.'</textarea>
            <br/>
                <button class="popup-submit" data-eval-id="'.$evalId.'">Valider</button>
            <br/><br/>
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
