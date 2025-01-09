<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ability;
use App\Models\Attend;
use App\Models\Attendee;
use App\Models\Evaluation;
use App\Models\Skill;
use App\Models\StatusType;
use App\Models\User;

class StudentController extends Controller
{
    public function getEleves(Request $request)
{
    $user_id = $request->input('user_id'); 

    $tableHtml = '';

    $eleve = User::find($user_id);

    $level = $eleve->LEVEL_ID_RESUME;
    $skills = Skill::where('LEVEL_ID', '=', $level)->get();
    

    $skillsWithAbilities = [];
    $i = 0;
    foreach ($skills as $skill) {
        $abilities = Ability::select('*')
            ->where('SKILL_ID', '=', $skill->SKILL_ID)
            ->get();
    
        $skillsWithAbilities[$i] = $abilities;
        $i++;
    }

    $sessions = Attendee::select('*', 'GRP2_USER.*')
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID_ATTENDEE', '=', 'GRP2_USER.USER_ID')
    ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_ATTENDEE.SESS_ID')
    ->where('GRP2_USER.USER_ID', '=', $user_id)
    ->get();    

    $evaluationsChaqueSeance = [];
    $i = 0;
    foreach($sessions as $session){
        $evaluations = Evaluation::select('*')
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
            ->get();
        $evaluationsChaqueSeance[$i] = $evaluations;
        $i++;
    }

    $taille = 0;
    foreach($skills as $skill){
        $taille += Ability::select('*')
        ->where('SKILL_ID', '=', $skill->SKILL_ID)
        ->count();
    }

    $statustype = StatusType::all();

    $tableHtml ='<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Compétence</th>
            <th>Aptitude</th>
            <th>Évolution</th>
        </tr> 
    </thead>  
    <tbody>';
    $i = 0;

    foreach($sessions as $session){
        $tableHtml.='<td rowspan="'.$taille.'" class="session-date">'.
        $session->SESS_DATE.
        '</td>'
        ;
        foreach($skills as $skill){
            $nombre = Ability::select('*')
                            ->where('SKILL_ID', '=', $skill->SKILL_ID)
                                ->count();
            $tableHtml.='
            <td rowspan="'.$nombre.'" class="skill">'.
            $skill->SKILL_LABEL.'</td>';
            $aptitude = Ability::select('*')
                                ->where('SKILL_ID', '=', $skill->SKILL_ID)->get();
            $compteur = 0;
            foreach($aptitude as $apt){
                $evaluationTrouvee = null;
                foreach($evaluationsChaqueSeance[$i] as $eval) {
                    if($eval->ABI_ID == $apt->ABI_ID){ 
                        $evaluationTrouvee = $eval;
                        break;
                    }
                }
                if($compteur != 0){
                    $tableHtml.= '<tr>';
                }
                $tableHtml.='<td>'.$apt->ABI_LABEL.'</td>';
                $tableHtml.='<td class="decoration">';
                if ($session->SESS_DATE > now()) {
                    $tableHtml .= '<form class="evalForm" method="POST" action="/submitEvaluation" onsubmit="submitEvalForm('.$eval->EVAL_ID.') 
                    data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '" data-user-id="' . $user_id 
                    . '" data-abi-id="' . $apt->ABI_ID . '" data-sess-id="' . $session->SESS_ID.'">

                                    <input type="hidden" name="eval_id" value="'.$eval->EVAL_ID.'">
                                    <button type="button" class="eval-btn">Obs'.  $apt->ABI_ID  .'</button>
                                </form>';


                    $tableHtml .= '<select class="scroll" data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '" data-user-id="' . $user_id 
                    . '" data-abi-id="' . $apt->ABI_ID . '" data-sess-id="' . $session->SESS_ID . '">';
                    
                    if ($evaluationTrouvee) {
                        $tableHtml .= '<option selected>' . $evaluationTrouvee->STATUSTYPE_LABEL . '</option>';
                    } else {
                        $tableHtml .= '<option></option>';
                    }

                    foreach ($statustype as $statutype) {
                        $tableHtml .= '<option value="' . $statutype->STATUSTYPE_ID . '">' . $statutype->STATUSTYPE_LABEL . '</option>';
                    }

                    $tableHtml .= '</select>';
                } else {

                    if ($evaluationTrouvee) {
                        $tableHtml .= $evaluationTrouvee->STATUSTYPE_LABEL;
                    } else{
                        $tableHtml.='Non évalué';
                    }
                }
                $tableHtml.='</td> </tr>';
                if($compteur != 0){
                    $tableHtml.= '</tr>';
                }
                $compteur++;
            }
            $tableHtml.='</td>';
        }
        $tableHtml.='</tr>';
        $i++;
    }
    $tableHtml.='</tbody>
    </table>';

    return response()->json(['html' => $tableHtml]);
}

}
