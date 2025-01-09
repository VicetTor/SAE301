<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB ;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function dataClub(){
        $clubName=DB::table('REPORT')
        ->select('CLUB_NAME')
        ->join('grp2_club','grp2_club.club_id','=','report.club_id')
        ->where('user_id', '=', Session('user_id'))
        ->first();

        echo var_dump($clubName);
        return view('Home', ['clubName'=>$clubName]);





    }
}
