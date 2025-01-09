<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    function create(){
        return view('ConnexionPage');
    }

    function tryConnect(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $mail = $request->input('email');
        $password = $request->input('password');

        $user =USER::where('USER_MAIL','=',$mail)->first();;
        if($user && Hash::check($password, $user->USER_PASSWORD)){
            echo $user;
            Session::put('user_mail', $user->USER_MAIL);
            Session::put('user_firstname', $user->USER_FIRSTNAME);
            Session::put('user_lastname', $user->USER_LASTNAME);
            Session::put('user_phonenumber', $user->USER_PHONENUMBER);
            Session::put('user_birthdate', $user->USER_BIRTHDATE);
            Session::put('user_address', $user->USER_ADDRESS);
            Session::put('user_postalcode', $user->USER_POSTALCODE);
            Session::put('user_licensenumber', $user->USER_LICENSENUMBER);
            Session::put('user_mediccertificatedate', $user->MEDICCERTIFICATEDATE);
            Session::put('user_id', $user->USER_ID);
            Session::put('level_id', $user->LEVEL_ID);
            Session::put('level_id_resume', $user->LEVEL_ID_RESUME);
            Session::put('type_id', $user->TYPE_ID);
            if($user->USER_ISFIRSTLOGIN == 1) {
               return redirect()->route('firstconnexion', ['user' => $user]);
            }
            return redirect()->route('students');
        }else{

            Session::flash('fail', 1);
            return back()->withInput();
        }
    }
}

?>
