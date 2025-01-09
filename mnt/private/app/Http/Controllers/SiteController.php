<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    /**
     * Show the edit form for modifying the site's settings.
     * 
     * Retrieves the club's ID from the REPORT table, fetches the current site data,
     * and passes the values (site name, color, logo) to the view for editing.
     * 
     * @return \Illuminate\View\View
     */

    /**
     * @OA\Get(
     *     path="/api/site/edit",
     *     summary="Show the edit form for modifying the site's settings",
     *     tags={"Site"},
     *     @OA\Response(
     *         response=200,
     *         description="Edit form displayed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="siteName", type="string", example="Secoule"),
     *             @OA\Property(property="siteColor", type="string", example="#005C8F"),
     *             @OA\Property(property="siteLogo", type="string", format="base64", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club ID not found"
     *     )
     * )
     */
    public function showEditForm()
    {
        // Retrieve the CLUB_ID based on the current user's ID (from the session)
        $clubID = DB::table('REPORT')
            ->select('grp2_club.CLUB_ID')
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
            ->where('user_id', '=', Session('user_id'))
            ->first();

        // Check if a club ID was found
        if ($clubID) {
            $clubID = $clubID->CLUB_ID; // Extract the actual CLUB_ID value
        } else {
            // Handle the case where no record is found
            return redirect()->back()->withErrors('Club ID not found.');
        }

        // Retrieve the site's settings based on the club ID
        $site = DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->first();

        // Set default values if no site data is found
        $siteName = $site->SITE_NAME ?? 'Secoule'; // Default site name
        $siteColor = $site->SITE_COLOR ?? '#005C8F'; // Default site color
        $siteLogo = $site->SITE_LOGO ? 'data:image/png;base64,' . base64_encode($site->SITE_LOGO) : null; // Convert logo to base64 if available

        // Store these values in the session for later use
        session(['site_name' => $siteName]);
        session(['site_color' => $siteColor]);
        session(['site_logo' => $siteLogo]);

        // Pass the variables to the view for rendering
        return view('SiteModifying', compact('siteName', 'siteColor', 'siteLogo'));
    }

    /**
     * Handle the form submission to update the site's settings.
     * 
     * Validates the input, updates or inserts new site data into the database,
     * updates the CSS file, clears and caches the config, and redirects with a success message.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * @OA\Post(
     *     path="/api/site/update",
     *     summary="Handle the form submission to update the site's settings",
     *     tags={"Site"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"site_name", "site_color"},
     *             @OA\Property(property="site_name", type="string", example="Secoule"),
     *             @OA\Property(property="site_color", type="string", format="hex", example="#005C8F"),
     *             @OA\Property(property="site_logo", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Site information updated successfully",
     *         @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Site information has been successfully updated."))
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Club ID not found"
     *     )
     * )
     */
    public function updateSite(Request $request)
    {
        // Validate the form data
        $request->validate([
            'site_name' => 'required|string|max:255', // Site name must be a string, max 255 characters
            'site_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/', // Site color must be a valid hex color code
            'site_logo' => 'nullable|image|mimes:png|max:2048', // Site logo should be a PNG image, max 2MB
        ]);

        // Get the validated input data
        $siteName = $request->input('site_name');
        $siteColor = $request->input('site_color');
        $logoData = null; // Initialize logo data as null

        // Retrieve the CLUB_ID based on the current user's ID (from the session)
        $clubID = DB::table('REPORT')
            ->select('grp2_club.CLUB_ID')
            ->join('grp2_club', 'grp2_club.club_id', '=', 'report.club_id')
            ->where('user_id', '=', Session('user_id'))
            ->first();

        // Check if a club ID was found
        if ($clubID) {
            $clubID = $clubID->CLUB_ID; // Extract the actual CLUB_ID value
        } else {
            // Handle the case where no record is found
            return redirect()->back()->withErrors('Club ID not found.');
        }

        // If a new logo is uploaded, convert it to binary data
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $logoData = file_get_contents($logo->getPathname()); // Read the file content as binary data
        }

        // Check if a site entry already exists for the current club
        $existingSite = DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->first();

        if ($existingSite) {
            // Update the existing site settings
            DB::table('GRP2_SITE')->where('CLUB_ID', $clubID)->update([
                'SITE_NAME' => $siteName,
                'SITE_COLOR' => $siteColor,
                'SITE_LOGO' => $logoData ?? $existingSite->SITE_LOGO, // Use existing logo if no new logo is uploaded
            ]);
        } else {
            // Insert a new site entry if none exists
            DB::table('GRP2_SITE')->insert([
                'CLUB_ID' => 1, // Assign a default CLUB_ID of 1 (this might need to be dynamic based on your use case)
                'SITE_NAME' => $siteName,
                'SITE_COLOR' => $siteColor,
                'SITE_LOGO' => $logoData,
            ]);
        }

        // Update the CSS file with the new color
        $this->updateCssFile($siteColor);

        // Clear and cache the config to ensure the changes are applied
        Artisan::call('config:clear');
        Artisan::call('config:cache');

        // Redirect with a success message
        return redirect()->back()->with('success', 'Site information has been successfully updated.');
    }

    /**
     * Update the CSS file to reflect the new site color.
     * 
     * This method searches for the site color definition in the CSS file and updates it with the new color.
     * 
     * @param  string  $color  The new site color to be applied.
     * @return void
     */
    protected function updateCssFile($color)
    {
        // Path to the CSS file
        $cssFilePath = public_path('css/app.css');

        // Get the current content of the CSS file
        $cssContent = file_get_contents($cssFilePath);

        // Search for the existing site color definition and replace it with the new color
        $pattern = '/--site-color: #[a-fA-F0-9]{6};/'; // Pattern to match the site color definition
        $replacement = '--site-color: ' . $color . ';'; // Replace with the new color

        // Replace the color in the CSS content
        $updatedCssContent = preg_replace($pattern, $replacement, $cssContent);

        // Save the updated CSS content back to the file
        file_put_contents($cssFilePath, $updatedCssContent);
    }
}
?>
