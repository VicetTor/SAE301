<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use OpenApi\Annotations as OA;

class HomeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     path="/api/club-name",
     *     summary="Fetch the club name associated with the logged-in user and display it on the Home page",
     *     tags={"Home"},
     *     @OA\Response(
     *         response=200,
     *         description="Club name fetched successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="clubName", type="string", description="The name of the club")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="User not logged in"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club not found"
     *     )
     * )
     */
    function dataClub(){
        if(Session('user_id') !=null){

            $clubName = DB::table('REPORT')
                ->select('CLUB_NAME')
                ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
                ->where('user_id', '=', Session('user_id'))
                ->first();

            if ($clubName) {
                return view('Home', ['clubName' => $clubName]);
            } else {
                return response()->json(['message' => 'Club not found'], 404);
            }
        } else {
            return response()->json(['message' => 'User not logged in'], 403);
        }
    }
}