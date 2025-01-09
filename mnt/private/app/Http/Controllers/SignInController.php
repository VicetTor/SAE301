<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Level;
use App\Models\typeUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class SignInController extends Controller
{

    public function show(){
        return view('SignInForm',['user' => User::all() , 'typeUser' => typeUser::all(), 'levels' => level::all()]);
    }

    public function signIn(CreatePostRequest $request){

        $utilisateur = new User();

        $utilisateur->USER_ID = DB::table('grp2_user')->count() +1;

        $utilisateur->LEVEL_ID = $request->input('LEVEL_ID');

        $utilisateur->TYPE_ID = $request->input('TYPE_ID');

        if($request->input('TYPE_ID') == 1){
            $utilisateur->LEVEL_ID_RESUME = $request->input('LEVEL_ID_RESUME');
        }
        else{
            $utilisateur->LEVEL_ID_RESUME = NULL;
        }

        $utilisateur->USER_MAIL = $request->input('USER_MAIL');

        $utilisateur->USER_PASSWORD = (Random::generate(6));

        $utilisateur->USER_FIRSTNAME = $request->input('USER_FIRSTNAME');

        $utilisateur->USER_LASTNAME = $request->input('USER_LASTNAME');

        $utilisateur->USER_PHONENUMBER = $request->input('USER_PHONENUMBER');

        $utilisateur->USER_BIRTHDATE = $request->input('USER_BIRTHDATE');

        $utilisateur->USER_ADDRESS = $request->input('USER_ADDRESS');

        $utilisateur->USER_POSTALCODE = $request->input('USER_POSTALCODE');

        $utilisateur->USER_LICENSENUMBER = $request->input('USER_LICENSENUMBER');

        $utilisateur->USER_MEDICCERTIFICATEDATE = $request->input('USER_MEDICCERTIFICATEDATE');

        $utilisateur->USER_ISFIRSTLOGIN = 1;
        $utilisateur->USER_ISACTIVE = 1;

        $utilisateur->save();
    }

}
