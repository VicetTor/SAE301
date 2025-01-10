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
        if(Session('type_id') != 2){
            return redirect()->route('home');
        }if(Session('user_id') == null){
            return redirect()->route('connexion');
        }

        // Récupere le club du responsable de formation
        $club = Report::select('CLUB_ID')
            ->where('USER_ID', '=', session('user_id'))
            ->first();

        echo $club;
        // Récupérer les utilisateurs liés à une formation
        $users = User::select('USER_FIRSTNAME', 'USER_LASTNAME','USER_ID')
            ->where('LEVEL_ID_RESUME', '=', session('train_id'))
            ->where('TYPE_ID', '=', 1)
            ->where('grp2_user.USER_ID', '!=', session('user_id'))
            ->distinct()
            ->get();

        // Liste des aptitudes
        $aptitudes = Ability::select('ABI_LABEL','ABI_ID')
        ->join('grp2_skill', 'grp2_skill.SKILL_ID', '=', 'grp2_ability.SKILL_ID')
        ->where('grp2_skill.LEVEL_ID', '=', session('train_id'))
        ->get();
        /*$aptitudes = [
            1 => 'A1 : s\'équilibrer',
            2 => 'A2 : Respecter le millieu',
            3 => 'A3 : S\'immerger'
        ];*/

        // Liste des initiateurs
        $initiators = User::select('USER_FIRSTNAME', 'USER_LASTNAME','USER_ID')
        ->where('TRAIN_ID', '=', session('train_id'))
        ->where('TYPE_ID', '=', 2)
        ->where('grp2_user.USER_ID', '!=', session('user_id'))
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
        if(session('type_id') != 2 ){
            return redirect()->route('home');
        }if(Session('user_id') == null){
            return redirect()->route('connexion');
        }

        //$dateTime = $validated['date'] . ' ' . $validated['time'];
        $sumSESSION = DB::table('grp2_session')->max('SESS_ID');

        $time = $request->DATE . ' ' . $request->time;

        // Enregistrer la nouvelle séance dans la table grp2_session
        DB::table('grp2_session')->insert([
            'SESS_DATE' => $time,
            'SESSTYPE_ID' => 1,
            'TRAIN_ID' => session('train_id'),
            'SESS_ID' => $sumSESSION + 1
        ]);



        for($i=0 ; $i < sizeof($request->user_id);$i++){

            $sumATTENDEE = DB::table('grp2_attendee')->max('ATTE_ID');

            DB::table('grp2_attendee')->insert([
                'ATTE_ID' => $sumATTENDEE + 1,
                'SESS_ID' => $sumSESSION + 1,
                'USER_ID' => $request->initiator_id[$i],
                'USER_ID_ATTENDEE' => $request->user_id[$i],
            ]);

            if($request->aptitude_id1[$i] != "-1"){

                $sumEVALUATION = DB::table('grp2_evaluation')->max('EVAL_ID');

                DB::table('grp2_evaluation')->insert([
                    'EVAL_ID' => $sumEVALUATION + 1,
                    'STATUSTYPE_ID' => 1,
                    'USER_ID' => $request->user_id[$i],
                    'SESS_ID' => $sumSESSION + 1,
                    'ABI_ID' => $request->aptitude_id1[$i],
                    'EVAL_OBSERVATION' => "",
                ]);
            }

            if($request->aptitude_id2[$i] != "-1"){

                $sumEVALUATION = DB::table('grp2_evaluation')->max('EVAL_ID');

                DB::table('grp2_evaluation')->insert([
                    'EVAL_ID' => $sumEVALUATION + 1,
                    'STATUSTYPE_ID' => 1,
                    'USER_ID' => $request->user_id[$i],
                    'SESS_ID' => $sumSESSION + 1,
                    'ABI_ID' => $request->aptitude_id2[$i],
                    'EVAL_OBSERVATION' => "",
                ]);
            }

            if($request->aptitude_id3[$i] != "-1"){

                $sumEVALUATION = DB::table('grp2_evaluation')->max('EVAL_ID');

                DB::table('grp2_evaluation')->insert([
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

    public function show()
    {
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }
        if (session('type_id') == 3 || session('type_id') == 4) {
            return redirect()->route('home');
        }

        // Fetches the club name associated with the user by joining the user, report, and club tables.
        $club = DB::table('grp2_user')
            ->join('report', 'report.USER_ID', '=', 'grp2_user.USER_ID') // Join the 'report' table to get club information
            ->join('grp2_club', 'grp2_club.CLUB_ID', '=', 'report.CLUB_ID') // Join the 'grp2_club' table to get the club name
            ->where('grp2_user.USER_ID', '=', session('user_id')) // Filter by user ID from the session
            ->select('grp2_club.CLUB_NAME') // Select only the club name
            ->first(); // Retrieve the first matching record (should only be one)

        // Fetches all the sessions that the user has attended, including related evaluations and abilities.
        $sessions = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.USER_ID', '=', 'grp2_attendee.USER_ID_ATTENDEE') // Join with attendee data to check user sessions
            ->join('grp2_session', 'grp2_attendee.SESS_ID', '=', 'grp2_session.SESS_ID') // Join with session data
            ->join('grp2_evaluation', 'grp2_session.SESS_ID', '=', 'grp2_evaluation.SESS_ID') // Join with evaluation data
            ->join('grp2_ability', 'grp2_ability.ABI_ID', '=', 'grp2_evaluation.ABI_ID') // Join with ability data
            ->join('grp2_skill', 'grp2_ability.SKILL_ID', '=', 'grp2_skill.SKILL_ID') // Join with skill data
            ->where('grp2_user.USER_ID', '=', session('user_id')) // Filter by user ID from the session
            ->get(); // Retrieve all matching records

        $initiatorSessions = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id') // Join with attendee data to check user sessions
            ->join('grp2_session', 'grp2_attendee.sess_id', '=', 'grp2_session.sess_id') // Join with session data
            ->where('grp2_user.user_id', '=', session('user_id')) 
            ->where('grp2_attendee.user_id', '=', session('user_id'))// Filter by user ID from the session
            ->get(); // Retrieve all matching records
        

        // Fetches the abilities associated with the sessions that the user has attended, including session and evaluation data.
        $abilities = DB::table('grp2_ability')
            ->join('grp2_evaluation', 'grp2_ability.ABI_ID', '=', 'grp2_evaluation.ABI_ID') // Join with evaluation data
            ->join('grp2_session', 'grp2_evaluation.SESS_ID', '=', 'grp2_session.SESS_ID') // Join with session data
            ->join('grp2_attendee', 'grp2_attendee.SESS_ID', '=', 'grp2_session.SESS_ID') // Join with attendee data
            ->join('grp2_user', 'grp2_attendee.USER_ID_ATTENDEE', '=', 'grp2_user.USER_ID') // Join with user data
            ->where('grp2_user.USER_ID', '=', session('user_id')) // Filter by user ID from the session
            ->get(); // Retrieve all matching records


        $initiator = DB::table('grp2_attendee')
            ->join('grp2_user','grp2_attendee.USER_ID','=','grp2_user.USER_ID')
            ->where('grp2_attendee.USER_ID_ATTENDEE', '=', session('user_id'))
            ->first();

        return view('SessionsPage',['club'=>$club, 'sessions'=>$sessions, 'abilities'=>$abilities,'initiator'=>$initiator, 'initiatorSessions'=>$initiatorSessions]);

        // The comment suggests that the retrieved data (models) should be stored in variables
        // and passed to the view in an array, following Blade template conventions.
    }
}
