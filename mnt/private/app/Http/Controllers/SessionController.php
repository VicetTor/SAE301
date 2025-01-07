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

        $seance = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id')
            ->join('attend','attend.atte_id','=','attend.atte_id')
            ->join('grp2_session','attend.sess_id','=','grp2_session.sess_id')
            ->join('grp2_evaluation', 'grp2_evaluation.sess_id', '=', 'grp2_session.sess_id')
            ->join('grp2_ability', 'grp2_evaluation.abi_id', '=', 'grp2_ability.abi_id')
            ->join('grp2_skill', 'grp2_skill.skill_id', '=', 'grp2_ability.skill_id')
            ->where('grp2_user.user_id', '=', session('user_id'))
            ->select('grp2_user.*', 'attend.*','grp2_session.*','grp2_ability.*','grp2_evaluation.*','grp2_skill.*')
            ->get();

        $session = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id')
            ->join('attend','attend.atte_id','=','attend.atte_id')
            ->join('grp2_session','attend.sess_id','=','grp2_session.sess_id')
            ->select(DB::raw('count(*) as nb'))
            ->get();

        $abilities =  DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id')
            ->join('attend','attend.atte_id','=','attend.atte_id')
            ->join('grp2_session','attend.sess_id','=','grp2_session.sess_id')
            ->join('grp2_evaluation', 'grp2_evaluation.sess_id', '=', 'grp2_session.sess_id')
            ->join('grp2_ability', 'grp2_evaluation.abi_id', '=', 'grp2_ability.abi_id')
            ->join('grp2_skill', 'grp2_skill.skill_id', '=', 'grp2_ability.skill_id')
            ->where('grp2_user.user_id', '=', session('user_id'))
            ->select('grp2_ability.*')
            ->get();




            /*
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
            ->where('grp2_club.club_id', session('user_id'))
            ->select('grp2_user.user_id')
            ->get();*/




        //session('user_id')


        return view('SessionsPage',['club'=>$club,'seance'=>$seance,'abilities'=>$abilities, 'session'=>$session]);

        //Ici, il faut récupérer les éléments des models avec les select puis les mettre dans des variables
        //Puis afficher la vue en passant les variables en tableau comme grafikart (Moteur template Blade 8:57 mins).
    }
}
