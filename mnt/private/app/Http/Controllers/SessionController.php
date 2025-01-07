<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function show(){





        return view('SessionsPage');

        //Ici, il faut récupérer les éléments des models avec les select puis les mettre dans des variables
        //Puis afficher la vue en passant les variables en tableau comme grafikart (Moteur template Blade 8:57 mins).
    }
}