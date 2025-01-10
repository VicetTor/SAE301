<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Evaluation;
use App\Models\Session;
use App\Models\User;

class LevelValidationController extends Controller
{
    
    public function validateLevel(Request $request){

        $user_id = $request->input('user_id');
        $id_resume = $request->input('id_resume');

        $user = User::find($user_id);
        
        $user->LEVEL_ID = $id_resume;
        $user->LEVEL_ID_RESUME = $id_resume+1;
        $user->save();
        

    }

}
