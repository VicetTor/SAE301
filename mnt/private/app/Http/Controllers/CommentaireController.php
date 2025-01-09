<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function commentaireEval(Request $request)
    {
        // Récupérer les données de la requête
        $evalId = $request->input('eval_id');
        $statutId = $request->input('statut_id');
        $user_id = $request->input('user_id');
        $abi_id = $request->input('abi_id');
        $sess_id = $request->input('sess_id');

        // Contenu de la popup
        $pop = '
        <div class="popup-content">
            <span class="popup-close">&times;</span>
            <h3>Contenu de la session</h3>
            <div id="popup-body">
                CHALUT A TOUS
                <br/> Eval id : ' . $evalId .'<br/> Statut id : ' . $statutId . '<br/> user id : ' . $user_id .'<br/> abi id : ' . $abi_id . '<br/> session id: ' . $sess_id .'
            </div>
        </div>';
        
        return response()->json(['html' => $pop]);
    }
}
