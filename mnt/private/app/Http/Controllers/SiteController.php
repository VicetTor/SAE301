<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SiteController extends Controller
{
    public function showEditForm()
    {
        // Charger les paramètres existants (par exemple, depuis une base de données ou un fichier)
        $siteName = config('app.name', 'Secoule'); // Exemple : utilisation de config/app.php
        $siteColor = config('APP_COLOR', '#005C8F'); // Exemple : utilisation de config/app.php
        return view('SiteModifying', compact('siteName', 'siteColor'));
    }

    public function updateSite(Request $request)
    {
        // Valider les données
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/', // Hex code validation
            'site_logo' => 'nullable|image|mimes:png|max:2048', // Validation du fichier logo
        ]);

        // Obtenir le nouveau nom
        $siteName = $request->input('site_name');
        $siteColor = $request->input('site_color');
        $this->updateEnvFile('APP_COLOR', $siteColor);

        $this->updateCssFile($siteColor);

        // Si un logo est téléchargé, gérer le remplacement
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');

            // Définir le nom du fichier
            $logoName = 'site_logo.' . $logo->getClientOriginalExtension();
            $oldLogoPath = public_path('images/site_logo/' . $logoName);

            // Supprimer l'ancien logo s'il existe
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath); // Supprime l'ancien logo
            }
    
            // Déplacer le nouveau logo dans le dossier images/site_logo
            $logo->move(public_path('images/site_logo'), $logoName);
        }

        // Mettre à jour le fichier .env
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
    
            // Remplacer APP_NAME
            $envContent = preg_replace(
                '/^APP_NAME=.*$/m',
                "APP_NAME=\"{$siteName}\"",
                $envContent
            );
    
            file_put_contents($envPath, $envContent);
        }

        

        // Recharger la configuration
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Le nom du site a été modifié.');
    }

    protected function updateEnvFile($key, $value)
    {
        $path = base_path('.env');
        $content = file_get_contents($path);

        // Recherche et mise à jour de la clé dans le fichier .env
        $pattern = "/^{$key}=(.*)$/m";
        $replacement = "{$key}={$value}";

        // Remplacement de la valeur
        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, $replacement, $content);
        } else {
            // Ajouter la clé et la valeur si elle n'existe pas
            $content .= "\n{$key}={$value}";
        }

        // Écriture dans le fichier .env
        file_put_contents($path, $content);
    }

    protected function updateCssFile($color)
    {
        $cssFilePath = public_path('css/app.css');  // Chemin vers votre fichier CSS
        $cssContent = file_get_contents($cssFilePath);

        // Rechercher et remplacer la couleur dans le fichier CSS
        $pattern = '/--site-color: #[a-fA-F0-9]{6}/'; // Assurez-vous que la couleur est au format hexadécimal
        $replacement = '--site-color: ' . $color;

        // Remplacer la couleur dans le CSS
        $cssContent = preg_replace($pattern, $replacement, $cssContent);

        // Sauvegarder les modifications dans le fichier CSS
        file_put_contents($cssFilePath, $cssContent);
    }
}
?>