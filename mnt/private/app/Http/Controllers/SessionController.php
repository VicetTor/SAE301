<?php

namespace App\Http\Controllers;

use App\Http\Requests\SessionRequest;
use App\Models\Ability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Report;
use Ramsey\Uuid\Type\Integer;

class SessionController extends Controller
{
    /**
     * Affiche le formulaire de création d'une séance.
     */
    public function create()
    {
        // Récupere le club du responsable de formation
        $club = Report::select('CLUB_ID')
            ->where('USER_ID', '=', session('user_id'))
            ->first();

        echo $club;
        // Récupérer les utilisateurs liés à une formation
        $users = User::select('USER_FIRSTNAME', 'USER_LASTNAME','USER_ID')
            ->where('LEVEL_ID_RESUME', '=', session('level_id_resume'))
            ->where('TYPE_ID', '=', 1)
            ->where('GRP2_USER.USER_ID', '!=', session('user_id'))
            ->distinct()
            ->get();

        // Liste des aptitudes
        $aptitudes = Ability::select('Abi_label','ABI_ID')
        ->join('grp2_skill', 'grp2_skill.skill_id', '=', 'GRP2_ABILITY.skill_id')
        ->where('grp2_skill.level_id', '=', session('level_id_resume'))
        ->get();
        /*$aptitudes = [
            1 => 'A1 : s\'équilibrer',
            2 => 'A2 : Respecter le millieu',
            3 => 'A3 : S\'immerger'
        ];*/

        // Liste des initiateurs
        $initiators = User::select('USER_FIRSTNAME', 'USER_LASTNAME','USER_ID')
            ->where('TYPE_ID', '=', 2)
            ->where('GRP2_USER.USER_ID', '!=', session('user_id'))
            ->distinct()
            ->get();
        /*$initiators = [
            1 => 'Catherine Laroche',
            2 => 'Pierre Cailloux',
            3 => 'Jo Laucéan'
        ];*/

        // Retourner la vue avec les données
        return view('SessionCreate', compact('users', 'aptitudes', 'initiators'));
    }

    /**
     * Enregistre une nouvelle séance.
     */
    public function store(SessionRequest $request)
    {


        //$dateTime = $validated['date'] . ' ' . $validated['time'];
        $sumSESSION = DB::table('GRP2_SESSION')->max('SESS_ID');

        $time = $request->DATE . ' ' . $request->time;

        // Enregistrer la nouvelle séance dans la table GRP2_SESSION
        DB::table('GRP2_SESSION')->insert([
            'SESS_DATE' => $time,
            'SESSTYPE_ID' => 1,
            'TRAIN_ID' => session('level_id_resume'),
            'SESS_ID' => $sumSESSION + 1
        ]);



        for($i=0 ; $i < sizeof($request->user_id);$i++){

            $sumATTENDEE = DB::table('GRP2_ATTENDEE')->max('ATTE_ID');

            DB::table('GRP2_ATTENDEE')->insert([
                'ATTE_ID' => $sumATTENDEE + 1,
                'SESS_ID' => $sumSESSION + 1,
                'USER_ID' => $request->user_id[$i],
                'USER_ID_ATTENDEE' => $request->initiator_id[$i],
            ]);

            if($request->aptitude_id1[$i] != -1){

                $sumEVALUATION = DB::table('GRP2_EVALUATION')->max('EVAL_ID');

                DB::table('GRP2_EVALUATION')->insert([
                    'EVAL_ID' => $sumEVALUATION + 1,
                    'STATUSTYPE_ID' => 1,
                    'USER_ID' => $request->user_id[$i],
                    'SESS_ID' => $sumSESSION + 1,
                    'ABI_ID' => $request->aptitude_id1[$i],
                    'EVAL_OBSERVATION' => "",
                ]);
            }

            if($request->aptitude_id2[$i] != -1){

                $sumEVALUATION = DB::table('GRP2_EVALUATION')->max('EVAL_ID');

                DB::table('GRP2_EVALUATION')->insert([
                    'EVAL_ID' => $sumEVALUATION + 1,
                    'STATUSTYPE_ID' => 1,
                    'USER_ID' => $request->user_id[$i],
                    'SESS_ID' => $sumSESSION + 1,
                    'ABI_ID' => $request->aptitude_id2[$i],
                    'EVAL_OBSERVATION' => "",
                ]);
            }

            if($request->aptitude_id3[$i] != -1){

                $sumEVALUATION = DB::table('GRP2_EVALUATION')->max('EVAL_ID');

                DB::table('GRP2_EVALUATION')->insert([
                    'EVAL_ID' => $sumEVALUATION + 1,
                    'STATUSTYPE_ID' => 1,
                    'USER_ID' => $request->user_id[$i],
                    'SESS_ID' => $sumSESSION + 1,
                    'ABI_ID' => $request->aptitude_id3[$i],
                    'EVAL_OBSERVATION' => "",
                ]);
            }
        }


        // Rediriger avec un message de succès
        return redirect()->route('sessions.create')->with('success', 'Séance créée avec succès !');
    }
}
