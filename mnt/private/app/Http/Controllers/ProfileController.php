<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Session;
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
        
        $inputMail = $request->input('inputEmail'); 
        $inputPhoneNumber = $request->input('inputPhoneNumber'); 
        $inputAddress = $request->input('inputAddress'); 
        $inputPostalCode = $request->input('inputPostalCode'); 

        $testUpdate = DB::table('grp2_user')
            ->where('user_id','=', session('user_id'))
            ->update(['user_mail' => $inputMail,'user_phonenumber' => $inputPhoneNumber,'user_address' => $inputAddress,'user_postalcode' => $inputPostalCode]);

        Session::put('user_mail',  $inputMail);
        Session::put('user_phonenumber', $inputPhoneNumber);
        Session::put('user_address', $inputAddress);
        Session::put('user_postalcode', $inputPostalCode);
        
        return view('MyProfile');
    }

    /*Session('user_id');*/
}
