<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FirstConnexionController extends Controller
{
    public function show(){
        return view('FirstConnexion',['user' => User::all()]);
    }


    public function fill(Request $request){





    }


}
