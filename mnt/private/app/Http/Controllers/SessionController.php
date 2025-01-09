<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; // For database queries

class SessionController extends Controller
{
    /**
     * Displays the session details and related data for the user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show()
    {
        // Fetches the club name associated with the user by joining the user, report, and club tables.
        $club = DB::table('grp2_user')
            ->join('report', 'report.user_id', '=', 'grp2_user.user_id') // Join the 'report' table to get club information
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id') // Join the 'grp2_club' table to get the club name
            ->where('grp2_user.user_id', '=', session('user_id')) // Filter by user ID from the session
            ->select('grp2_club.club_name') // Select only the club name
            ->first(); // Retrieve the first matching record (should only be one)

        // Fetches all the sessions that the user has attended, including related evaluations and abilities.
        $sessions = DB::table('grp2_user')
            ->join('grp2_attendee', 'grp2_user.user_id', '=', 'grp2_attendee.user_id_attendee') // Join with attendee data to check user sessions
            ->join('grp2_session', 'grp2_attendee.sess_id', '=', 'grp2_session.sess_id') // Join with session data
            ->join('grp2_evaluation', 'grp2_session.sess_id', '=', 'grp2_evaluation.sess_id') // Join with evaluation data
            ->join('grp2_ability', 'grp2_ability.abi_id', '=', 'grp2_evaluation.abi_id') // Join with ability data
            ->join('grp2_skill', 'grp2_ability.skill_id', '=', 'grp2_skill.skill_id') // Join with skill data
            ->where('grp2_user.user_id', '=', session('user_id')) // Filter by user ID from the session
            ->get(); // Retrieve all matching records

        // Fetches the abilities associated with the sessions that the user has attended, including session and evaluation data.
        $abilities = DB::table('grp2_ability')
            ->join('grp2_evaluation', 'grp2_ability.abi_id', '=', 'grp2_evaluation.abi_id') // Join with evaluation data
            ->join('grp2_session', 'grp2_evaluation.sess_id', '=', 'grp2_session.sess_id') // Join with session data
            ->join('grp2_attendee', 'grp2_attendee.sess_id', '=', 'grp2_session.sess_id') // Join with attendee data
            ->join('grp2_user', 'grp2_attendee.user_id_attendee', '=', 'grp2_user.user_id') // Join with user data
            ->where('grp2_user.user_id', '=', session('user_id')) // Filter by user ID from the session
            ->get(); // Retrieve all matching records


        $initiator = DB::table('grp2_attendee')
            ->join('grp2_user','grp2_attendee.user_id','=','grp2_user.user_id')
            ->where('grp2_attendee.user_id_attendee', '=', session('user_id'))
            ->first();

        return view('SessionsPage',['club'=>$club, 'sessions'=>$sessions, 'abilities'=>$abilities,'initiator'=>$initiator]);

        // The comment suggests that the retrieved data (models) should be stored in variables 
        // and passed to the view in an array, following Blade template conventions.
    }
}
