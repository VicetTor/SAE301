<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function showEditForm()
    {
        $clubID = DB::table('REPORT')
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

        session(['site_name' => $siteName]);
        session(['site_color' => $siteColor]);
        session(['site_logo' => $siteLogo]);

        // Passer les variables à la vue
        return view('SiteModifying', compact('siteName', 'siteColor', 'siteLogo'));
    }

    public function updateSite(Request $request)
    {
        // Valider les données
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/', // Validation d'un code hexadécimal
            'site_logo' => 'nullable|image|mimes:png|max:2048', // Validation du logo
        ]);

        // Obtenir les données
        $siteName = $request->input('site_name');
        $siteColor = $request->input('site_color');
        $logoData = null;

        $clubID=DB::table('REPORT')
        ->select('grp2_club.CLUB_ID')
        ->join('grp2_club','grp2_club.club_id','=','report.club_id')
        ->where('user_id', '=', Session('user_id'))
        ->first();

        if ($clubID) {
            $clubID = $clubID->CLUB_ID; // Extract the actual CLUB_ID value
        } else {
            // Handle the case where no record is found
            return redirect()->back()->withErrors('Club ID not found.');
        }

        // Si un logo est téléchargé, convertir le fichier en données binaires
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoData = file_get_contents($logo->getPathname());
        }

        // Vérifier si une entrée existe déjà pour le club (CLUB_ID = 1)
        $existingSite = DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->first();

        if ($existingSite) {
            // Mettre à jour les données existantes
            DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->update([
                'SITE_NAME' => $siteName,
                'SITE_COLOR' => $siteColor,
                'SITE_LOGO' => $logoData ?? $existingSite->SITE_LOGO,
            ]);
        } else {
            // Créer une nouvelle entrée
            DB::table('GRP2_SITE')->insert([
                'CLUB_ID' => 1,
                'SITE_NAME' => $siteName,
                'SITE_COLOR' => $siteColor,
                'SITE_LOGO' => $logoData,
            ]);
        }

        // Mettre à jour le fichier CSS avec la nouvelle couleur
        $this->updateCssFile($siteColor);

        // Recharger la configuration si nécessaire
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Les informations du site ont été mises à jour avec succès.');
    }

    // Méthode pour mettre à jour le fichier CSS
    protected function updateCssFile($color)
    {
        $cssFilePath = public_path('css/app.css'); // Chemin vers le fichier CSS
        $cssContent = file_get_contents($cssFilePath);

        // Rechercher et remplacer la couleur dans le fichier CSS
        $pattern = '/--site-color: #[a-fA-F0-9]{6};/'; // Correspond au format : --site-color: #XXXXXX;
        $replacement = '--site-color: ' . $color . ';';

        // Modifier le contenu CSS
        $updatedCssContent = preg_replace($pattern, $replacement, $cssContent);

        // Sauvegarder les modifications dans le fichier CSS
        file_put_contents($cssFilePath, $updatedCssContent);
    }

}
?>