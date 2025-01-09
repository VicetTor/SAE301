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
    function dataClub() {
        // Query the database to fetch the club name associated with the current user
        $clubName = DB::table('REPORT') // Start from the REPORT table
            ->select('CLUB_NAME') // Select the CLUB_NAME field
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id') // Join with the grp2_club table to link club_id
            ->where('user_id', '=', Session('user_id')) // Filter by the currently logged-in user's ID from the session
            ->first(); // Retrieve the first matching result

        // Return the 'Home' view with the retrieved club name passed as data
        return view('Home', ['clubName' => $clubName]);
    }
}
