<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_decode;


class SessionController extends Controller
{


    public function show(){


        //Ca marche !
        $club = DB::table('grp2_user')
            ->join('report', 'report.user_id', '=', 'grp2_user.user_id')
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
            ->where('grp2_user.user_id', '=', session('user_id'))
            ->select('grp2_club.club_name')
            ->first();


        $sessions = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id')
            ->join('grp2_session', 'grp2_attendee.sess_id', '=', 'grp2_session.sess_id')
            ->join('grp2_evaluation', 'grp2_session.sess_id', '=' ,'grp2_evaluation.sess_id')
            ->join('grp2_ability','grp2_ability.abi_id','=','grp2_evaluation.abi_id')
            ->join('grp2_skill','grp2_ability.skill_id','=', 'grp2_skill.skill_id')
            ->where('grp2_user.user_id', '=', session('user_id'))
            ->get();

        $abilities = DB::table('grp2_ability')
            ->join('grp2_evaluation','grp2_ability.abi_id','=','grp2_evaluation.abi_id')
            ->join('grp2_session','grp2_evaluation.sess_id','=','grp2_session.sess_id')
            ->get();








        return view('SessionsPage',['club'=>$club, 'sessions'=>$sessions, 'abilities'=>$abilities]);


        //Ici, il faut récupérer les éléments des models avec les select puis les mettre dans des variables
        //Puis afficher la vue en passant les variables en tableau comme grafikart (Moteur template Blade 8:57 mins).
    }
}
