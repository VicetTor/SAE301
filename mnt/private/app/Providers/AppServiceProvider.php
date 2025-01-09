<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
        $clubID = DB::table('report')
            ->select('grp2_club.CLUB_ID')
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
            ->where('user_id', '=', Session('user_id'))
            ->first();

        if ($clubID) {
            $clubID = $clubID->CLUB_ID; // Extraire la valeur réelle de CLUB_ID
        } else {
            // Gérer le cas où aucun enregistrement n'est trouvé
            return redirect()->back()->withErrors('Club ID non trouvé.');
        }

        // Charger les paramètres existants depuis la table GRP2_SITE
        $site = DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->first();

        // Si aucune donnée n'est trouvée, définir des valeurs par défaut
        $siteName = $site->SITE_NAME ?? 'Secoule';
        $siteColor = $site->SITE_COLOR ?? '#005C8F'; // Définir une couleur par défaut si non trouvée
        $siteLogo = $site->SITE_LOGO ? 'data:image/png;base64,' . base64_encode($site->SITE_LOGO) : null;
        // Partager ces valeurs avec toutes les vues
        View::share('siteLogo', $siteLogo);
        View::share('siteColor', $siteColor);
        View::share('siteName', $siteName);
        //
        /*DB::listen(function ($query) {
            Log::debug($query->sql);
            Log::debug($query->bindings);
            Log::debug($query->time);
        });*/
    }
}
