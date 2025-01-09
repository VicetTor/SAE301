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
    ->join('GRP2_USER', 'GRP2_ATTENDEE.USER_ID', '=', 'GRP2_USER.USER_ID')
    ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_ATTENDEE.SESS_ID')
    ->where('GRP2_USER.USER_ID', '=', $user_id)
    ->get();    

    $evaluationsChaqueSeance = [];
    foreach ($sessions as $session) {
        $evaluations = Evaluation::select('*')
            ->join('GRP2_STATUSTYPE', 'GRP2_STATUSTYPE.STATUSTYPE_ID', '=', 'GRP2_EVALUATION.STATUSTYPE_ID')
            ->join('GRP2_SESSION', 'GRP2_SESSION.SESS_ID', '=', 'GRP2_EVALUATION.SESS_ID')
            ->where('GRP2_EVALUATION.SESS_ID', '=', $session->SESS_ID)
            ->orderBy('GRP2_SESSION.SESS_DATE', 'asc')
            ->get();
        $evaluationsChaqueSeance[] = $evaluations;
    }

    $statustype = StatusType::all();

    $tableHtml .= '<table id="tabletable">';
    $tableHtml .= '<thead><tr><th></th>';

    foreach ($skills as $skill) {
        $nombre = Ability::where('SKILL_ID', '=', $skill->SKILL_ID)->count();
        $tableHtml .= '<th colspan="' . $nombre . '">' . $skill->SKILL_LABEL . '</th>';
    }

    $tableHtml .= '</tr></thead><tbody>';

    $tableHtml .= '<tr><th></th>';
    foreach ($skillsWithAbilities as $abilities) {
        foreach ($abilities as $ability) {
            $tableHtml .= '<td>' . $ability->ABI_LABEL . '</td>';
        }
    }
    $tableHtml .= '</tr>';

    $i = 0;
    foreach ($sessions as $session) {
        $tableHtml .= '<tr><td>' . $session->SESS_DATE . '</td>';

        foreach ($skillsWithAbilities as $abilities) {
            foreach ($abilities as $ability) {

                $evaluationTrouvee = null;
                foreach ($evaluationsChaqueSeance[$i] as $eval) {
                    if ($eval->ABI_ID == $ability->ABI_ID && $eval->USER_ID == $user_id) {
                        $evaluationTrouvee = $eval;
                        break;
                    }
                }

                $tableHtml .= '<td>';
                if ($session->SESS_DATE > now()) {
                    
                    $tableHtml .= '<select class="scroll" data-eval-id="' . ($evaluationTrouvee ? $evaluationTrouvee->EVAL_ID : 0) . '" data-user-id="' . $user_id . '" data-abi-id="' . $ability->ABI_ID . '" data-sess-id="' . $session->SESS_ID . '">';
                    
                    
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
                    }
                }
                $tableHtml .= '</td>';
            }
        }

        $tableHtml .= '</tr>';
        $i++;
    }

    $tableHtml .= '</tbody></table>';

    return response()->json(['html' => $tableHtml]);
}

}
