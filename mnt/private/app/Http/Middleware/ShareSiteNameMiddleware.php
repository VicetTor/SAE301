<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShareSiteNameMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $site = DB::table('GRP2_SITE')->where('CLUB_ID', 1)->first();
        $siteName = $site->SITE_NAME ?? 'Secoule';

        view()->share('siteName', $siteName);

        return $next($request);
    }
}
