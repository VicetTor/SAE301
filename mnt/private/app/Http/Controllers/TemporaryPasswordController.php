<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class TemporaryPasswordController extends Controller {

    /**
     * Displays the page with all active users (excluding admins).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show() {

        if (session('type_id') != 4) {
            return redirect()->route('home');
        }
        if (session('user_id') == null) {
            return redirect()->route('connexion');
        }   

        $club =DB::table('report')
        ->where('report.USER_ID' , '=', Session('user_id'))
        ->first();  
        $clubId = $club->CLUB_ID;

        $users = DB::table('grp2_user')
        ->join('report','report.USER_ID','=','grp2_user.USER_ID')
        ->where('report.CLUB_ID', '=',  $clubId)
        ->where('USER_ISFIRSTLOGIN', '=', 1)
        ->get();
                
        return view('TemporaryPassword', ['users' => $users]);
    }
}

?>
