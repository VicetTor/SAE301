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
use OpenApi\Annotations as OA;

class StudentController extends Controller {
    /**
     * @OA\Get(
     *     path="/api/students",
     *     summary="Get the details of a student's sessions and evaluations",
     *     tags={"Student"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         description="User ID of the student",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Student details retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="html", type="string", example="<table>...</table>")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Student not found"
     *     )
     * )
     */
    public function getEleves(Request $request) {
        if (session('type_id') == 1) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        $statustype = StatusType::all();
        $user_id = $request->input('user_id');

        $tableHtml = '';

        $eleve = User::find($user_id);

        if (!$eleve) {
            return response()->json(['error' => 'Student not found'], 404);
        }

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
                    if ($session->SESS_DATE > now()) {

                        $tableHtml .= '<select class="scroll" data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '"
                        data-user-id="' . $user_id . '" data-abi-id="' . $apt->ABI_ID . '" data-sess-id="' . $session->SESS_ID . '">';

                        if ($evaluationTrouvee) {
                            $tableHtml .= '<option selected>' . $evaluationTrouvee->STATUSTYPE_LABEL .$evaluationTrouvee->EVAL_ID.'</option>';
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
        }
        $tableHtml.='</tbody>
        </table>';

        return response()->json(['html' => $tableHtml]);
    }
}
