<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function getEleves()
    {
        $eleves = User::all();

        return response()->json($eleves);
    }
}
