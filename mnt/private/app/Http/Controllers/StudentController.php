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
use Illuminate\Support\Facades\DB;
use App\Models\Session;


class StudentController extends Controller
{
    public function getEleves(Request $request)
{
    $statustype = DB::select('SELECT * FROM grp2_statustype');

    $user_id = $request->input('user_id'); 
    $type_utilisateur = Session('type_id');
    $tableHtml = '';

    $eleve = User::find($user_id);

    $level = $eleve->LEVEL_ID_RESUME;
    

    $sessions = Attendee::select('*', 'GRP2_USER.*')
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID_attendee', '=', 'GRP2_USER.USER_ID')
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
            ->where('GRP2_EVALUATION.USER_ID', '=', $user_id)
            ->get();
        $evaluationsChaqueSeance[$i] = $evaluations;
        $i++;
    }



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

    foreach($sessions as $session)

        $skills = DB::select(DB::raw('
        select distinct GRP2_SKILL.SKILL_ID, GRP2_SKILL.SKILL_LABEL from GRP2_SKILL
        inner join GRP2_ABILITY using (SKILL_ID)
        inner join GRP2_EVALUATION using (ABI_ID)
        where GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
        and GRP2_SKILL.LEVEL_ID ='.$level.'
        and GRP2_EVALUATION.USER_ID ='.$user_id
        ));

        

        $nbSkills = count($skills);
        $taille = 0;
        foreach($skills as $skill){

            $result = DB::select(DB::raw('
            select * from GRP2_ABILITY
            inner join GRP2_EVALUATION using (ABI_ID)
            where GRP2_ABILITY.SKILL_ID ='.$skill->SKILL_ID.'
            and GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
            and GRP2_EVALUATION.USER_ID ='.$user_id
            ));

            $taille+=count($result);
        }

        $tableHtml.='<td rowspan="'.$taille.'" class="session-date">'.
        $session->SESS_DATE.
        '</td>';

        foreach($skills as $skill){


            $result = DB::select(DB::raw('
            select * from GRP2_ABILITY
            inner join GRP2_EVALUATION using (ABI_ID)
            where GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
            and GRP2_EVALUATION.USER_ID ='.$user_id.'
            and GRP2_ABILITY.SKILL_ID ='.$skill->SKILL_ID
            ));
            $nombre = count($result);


            $tableHtml.='
            <td rowspan="'.$nombre.'" class="skill">'.
            $skill->SKILL_LABEL.'</td>';

            $aptitude = DB::select(DB::raw('
            select * from GRP2_ABILITY
            inner join GRP2_EVALUATION using (ABI_ID)
            where SKILL_ID = '.$skill->SKILL_ID.'
            and GRP2_EVALUATION.SESS_ID ='.$session->SESS_ID.'
            and GRP2_EVALUATION.USER_ID ='.$user_id
            ));
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
                $tableHtml .= '
                    <button type="button" class="eval-btn btn btn-primary btn-sm me-3" data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '" data-user-id="' . $user_id 
                    . '" data-abi-id="' . $apt->ABI_ID . '" data-sess-id="' . $session->SESS_ID.'">Obs.</button>
                                ';
                if ($session->SESS_DATE > now() && $type_utilisateur == 2) {

                    $tableHtml .= '<select class="scroll" data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '" data-user-id="' . $user_id 
                    . '" data-abi-id="' . $apt->ABI_ID . '" data-sess-id="' . $session->SESS_ID . '">';
                    
                    if ($evaluationTrouvee) {
                        $tableHtml .= '<option selected>' . $evaluationTrouvee->STATUSTYPE_LABEL.$evaluationTrouvee->EVAL_ID . '</option>';
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
        $tableHtml.='</td>';
        $i++;
    
    $tableHtml.='</tbody>
    </table>';

    return response()->json(['html' => $tableHtml]);
}

}
