<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShareSiteNameMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $site = DB::table('grp2_site')->where('CLUB_ID', 1)->first();
        $siteName = $site->SITE_NAME ?? 'Secoule';

        view()->share('siteName', $siteName);

        return $next($request);
    }
}
