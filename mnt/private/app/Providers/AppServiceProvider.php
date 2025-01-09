<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $site = DB::table('GRP2_SITE')->where('CLUB_ID', 1)->first(); // Remplacez 1 par le CLUB_ID dynamique
        $siteLogo = $site && $site->SITE_LOGO ? 'data:image/png;base64,' . base64_encode($site->SITE_LOGO) : null;

        // Partager les données du logo avec toutes les vues
        View::share('siteLogo', $siteLogo);
    }
}
