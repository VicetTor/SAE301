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
    

    $sessions = Attendee::select('*', 'grp2_user.*')
    ->join('grp2_user', 'grp2_attendee.USER_ID_ATTENDEE', '=', 'grp2_user.USER_ID')
    ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_attendee.SESS_ID')
    ->where('grp2_user.USER_ID', '=', $user_id)
    ->get();

    
    $evaluationsChaqueSeance = [];
    $i = 0;
    foreach($sessions as $session){
        $evaluations = Evaluation::select('*')
            ->join('grp2_statustype', 'grp2_statustype.STATUSTYPE_ID', '=', 'grp2_evaluation.STATUSTYPE_ID')
            ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_evaluation.SESS_ID')
            ->where('grp2_evaluation.SESS_ID', '=', $session->SESS_ID)
            ->where('grp2_evaluation.USER_ID', '=', $user_id)
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
        select distinct grp2_skill.SKILL_ID, grp2_skill.SKILL_LABEL from grp2_skill
        inner join grp2_ability using (SKILL_ID)
        inner join grp2_evaluation using (ABI_ID)
        where grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
        and grp2_skill.LEVEL_ID ='.$level.'
        and grp2_evaluation.USER_ID ='.$user_id
        ));

        

        $nbSkills = count($skills);
        $taille = 0;
        foreach($skills as $skill){

            $result = DB::select(DB::raw('
            select * from grp2_ability
            inner join grp2_evaluation using (ABI_ID)
            where grp2_ability.SKILL_ID ='.$skill->SKILL_ID.'
            and grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
            and grp2_evaluation.USER_ID ='.$user_id
            ));

            $taille+=count($result);
        }

        $level = $eleve->LEVEL_ID_RESUME;

        $sessions = Attendee::select('*', 'grp2_user.*')
            ->join('grp2_user', 'grp2_attendee.USER_ID_ATTENDEE', '=', 'grp2_user.USER_ID')
            ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_attendee.SESS_ID')
            ->where('grp2_user.USER_ID', '=', $user_id)
            ->get();

        $evaluationsChaqueSeance = [];
        $i = 0;
        foreach($sessions as $session){
            $evaluations = Evaluation::select('*')
                ->join('grp2_statustype', 'grp2_statustype.STATUSTYPE_ID', '=', 'grp2_evaluation.STATUSTYPE_ID')
                ->join('grp2_session', 'grp2_session.SESS_ID', '=', 'grp2_evaluation.SESS_ID')
                ->where('grp2_evaluation.SESS_ID', '=', $session->SESS_ID)
                ->where('grp2_evaluation.USER_ID', '=', $user_id)
                ->get();
            $evaluationsChaqueSeance[$i] = $evaluations;
            $i++;
        }

        $tableHtml = '<table>
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

            $skills = DB::select(DB::raw('
            select distinct grp2_skill.SKILL_ID, grp2_skill.SKILL_LABEL from grp2_skill
            inner join grp2_ability using (SKILL_ID)
            inner join grp2_evaluation using (ABI_ID)
            where grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
            and grp2_skill.LEVEL_ID ='.$level.'
            and grp2_evaluation.USER_ID ='.$user_id
            ));

            $nbSkills = count($skills);
            $taille = 0;
            foreach($skills as $skill){

                $result = DB::select(DB::raw('
                select * from grp2_ability
                inner join grp2_evaluation using (ABI_ID)
                where grp2_ability.SKILL_ID ='.$skill->SKILL_ID.'
                and grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                and grp2_evaluation.USER_ID ='.$user_id
                ));

                $taille+=count($result);
            }

        $tableHtml.='<td rowspan="'.$taille.'" class="session-date">'.
        $session->SESS_DATE.
        '</td>';

        foreach($skills as $skill){


                $result = DB::select(DB::raw('
                select * from grp2_ability
                inner join grp2_evaluation using (ABI_ID)
                where grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                and grp2_evaluation.USER_ID ='.$user_id.'
                and grp2_ability.SKILL_ID ='.$skill->SKILL_ID
                ));
                $nombre = count($result);

            $tableHtml.='
            <td rowspan="'.$nombre.'" class="skill">'.
            $skill->SKILL_LABEL.'</td>';

                $aptitude = DB::select(DB::raw('
                select * from grp2_ability
                inner join grp2_evaluation using (ABI_ID)
                where SKILL_ID = '.$skill->SKILL_ID.'
                and grp2_evaluation.SESS_ID ='.$session->SESS_ID.'
                and grp2_evaluation.USER_ID ='.$user_id
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
                        $tableHtml .= '<option selected>' . $evaluationTrouvee->STATUSTYPE_LABEL. '</option>';
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
}
