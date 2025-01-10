<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SiteDataMiddleware
{
    public function handle($request, Closure $next)
    {
        // Récupérer le CLUB_ID associé à l'utilisateur actuel
        $clubID = DB::table('report')
            ->select('grp2_club.CLUB_ID')
            ->join('grp2_club', 'grp2_club.CLUB_ID', '=', 'report.CLUB_ID')
            ->where('USER_ID', '=', Session('user_id'))
            ->first();

            if ($clubID) {
                $clubID = $clubID->CLUB_ID;
                $site = DB::table('grp2_site')->where('CLUB_ID', $clubID)->first();
                $siteName = $site->SITE_NAME ?? 'Secoule';
                $siteColor = $site->SITE_COLOR ?? '#005C8F';
                $siteLogo = $site->SITE_LOGO ? 'data:image/png;base64,' . base64_encode($site->SITE_LOGO) : null;
    
                session(['site_name' => $siteName]);
                session(['site_color' => $siteColor]);
                session(['site_logo' => $siteLogo]);
    
                View::share('siteName', $siteName);
                View::share('siteColor', $siteColor);
                View::share('siteLogo', $siteLogo);
            }
    
            return $next($request);
    }
}

?>