<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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

        return redirect()->route('profile');
    }


    function up(){
        $popUps=DB::table('report')
        ->join('grp2_user','grp2_user.user_id','=','report.user_id')
        ->join('grp2_club','grp2_club.club_id','=','report.club_id')
        ->where('type_id','=','3')
        ->first();

        return view('MyProfile', ['popUps'=>$popUps]);
    }

    function logOut(){
        auth()->logout();
        Session::flush();
        return redirect()->route('connexion');
    }

    function pswdUpdate(Request $request)
    {
        $inputPswd = $request->input('inputActualPassword'); 
        $inputNewPswd = $request->input('inputNewPassword'); 
        $inputPswdVerif = $request->input('inputPasswordVerif'); 

        $userPswd = DB::table('grp2_user')
            ->select('*')
            ->where('USER_ID','=', session('user_id'))->first();

        if(Hash::check($inputPswd, $userPswd->USER_PASSWORD)){
            if( $inputNewPswd === $inputPswdVerif ){
                $testUpdate = DB::table('grp2_user')
                ->where('user_id','=', session('user_id'))
                ->update(['user_password' => Hash::make($inputNewPswd)]);
                return redirect()->route('profile')->with('success', 'Mot de passe mis à jour avec succès.');
            }else{
                return redirect()->back()->withErrors(['inputNewPassword' => 'Le nouveau mot de passe ne correspond pas à la vérification.']);
            }
        }else{
            return redirect()->back()->withErrors(['inputActualPassword' => 'Le mot de passe actuel est incorrect.']);
        }
        

    }
}
