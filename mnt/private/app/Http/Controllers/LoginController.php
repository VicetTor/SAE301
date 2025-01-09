<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    function create(){
        return view('ConnexionPage');
    }

    function tryConnect(Request $request){


        $mail = $request->input('email');
        $password = $request->input('password');

        $utilisateur = USER::select('*')
            ->where('USER_MAIL','=',$mail)
            ->where('USER_PASSWORD','=',$password)->first();

        if($utilisateur != null){
            echo $utilisateur;
            Session::put('user_mail', $utilisateur->USER_MAIL);
            Session::put('user_firstname', $utilisateur->USER_FIRSTNAME);
            Session::put('user_lastname', $utilisateur->USER_LASTNAME);
            Session::put('user_phonenumber', $utilisateur->USER_PHONENUMBER);
            Session::put('user_birthdate', $utilisateur->USER_BIRTHDATE);
            Session::put('user_address', $utilisateur->USER_ADDRESS);
            Session::put('user_postalcode', $utilisateur->USER_POSTALCODE);
            Session::put('user_licensenumber', $utilisateur->USER_LICENSENUMBER);
            Session::put('user_mediccertificatedate', $utilisateur->MEDICCERTIFICATEDATE);
            Session::put('user_id', $utilisateur->USER_ID);
            Session::put('level_id', $utilisateur->LEVEL_ID);
            Session::put('level_id_resume', $utilisateur->LEVEL_ID_RESUME);
            Session::put('type_id', $utilisateur->TYPE_ID);
            return redirect()->route('students');
        } else{
            Session::put('fail', 1);
            return view('ConnexionPage');
        }
    }
}

?>