<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Fetch the club name associated with the logged-in user and display it on the Home page.
     *
     * @return \Illuminate\View\View The Home view with the club name data.
     */
    function dataClub(){
        if(Session('user_id') !=null){

            $clubName=DB::table('REPORT')
            ->select('CLUB_NAME')
            ->join('grp2_club','grp2_club.club_id','=','report.club_id')
            ->where('user_id', '=', Session('user_id'))
            ->first();

            return view('Home', ['clubName'=>$clubName]);
        }else{
            return redirect()->route('connexion');
        }
    }


}
