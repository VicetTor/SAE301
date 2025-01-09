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

        $users = DB::table('grp2_user')
        ->where('USER_ISFIRSTLOGIN', '=', 1)
                ->get();
                
        return view('TemporaryPassword', ['users' => $users]);
    }
}

?>
