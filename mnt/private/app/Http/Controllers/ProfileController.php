<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProfileController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function infoUpdate(Request $request)
    {
    
        // Valider les données 
        $validatedData = $request->validate([ 
            'inputEmail' => 'required|email|max:255', 
            'inputPhoneNumber' => 'required|string|max:15', 
            'inputAddress' => 'required|string|max:255', 
            'inputPostalCode' => 'required|string|size:5', 
        ], [
             'inputEmail.required' => 'L\'adresse email est obligatoire.', 
             'inputEmail.email' => 'Veuillez fournir une adresse email valide.', 
             'inputPhoneNumber.required' => 'Le numéro de téléphone est obligatoire.', 
             'inputAddress.required' => 'L\'adresse est obligatoire.', 
             'inputPostalCode.required' => 'Le code postal est obligatoire.', 
             'inputPostalCode.size' => 'Le code postal doit comporter exactement 5 caractères.'
        ]);
        
        echo 'Email: '.$request->input('inputEmail') . '<br>'; 
        echo 'Numéro de téléphone: ' . $request->input('inputPhoneNumber') . '<br>'; 
        echo 'Adresse: ' . $request->input('inputAddress') . '<br>'; 
        echo 'Code postal: ' . $request->input('inputPostalCode') . '<br>'; 
        
        exit;

        /*return view('MyProfile');*/
    }

    /*Session('user_id');*/
}
