<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function commentaireEval(Request $request)
{
    $evalId = $request->input('eval_id');
    $statutId = $request->input('statut_id');
    $user_id = $request->input('user_id');
    $abi_id = $request->input('abi_id');
    $sess_id = $request->input('sess_id');

    $pop = '
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <h3>Contenu de la session</h3>
        <div id="popup-body">
            <label for="popup-comment">commentaire :</label>
            <textarea id="popup-comment" rows="4" cols="50">chalut</textarea>
            <br/>
            <button id="popup-submit">Valider</button>
            <br/><br/>
            Eval id : ' . $evalId . '<br/> 
            Statut id : ' . $statutId . '<br/> 
            User id : ' . $user_id . '<br/> 
            Abi id : ' . $abi_id . '<br/> 
            Session id: ' . $sess_id . '
        </div>
    </div>';

    return response()->json(['html' => $pop]);
}

}
