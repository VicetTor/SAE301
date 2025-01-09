<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Base');
});

Route::get('/connexion',function(){
    return view('ConnexionPage');
})->name('connexion');

Route::get('/inscription',[\App\Http\Controllers\SignInController::class,'show'])->name('inscription');
Route::post('/inscription',[\App\Http\Controllers\SignInController::class,'signIn'])->name('inscriptionValidate');

Route::get('/profile',function(){
    return view('MyProfile');
})->name('profile');

/*Route::get('/session/create',function(){
    return view('SessionCreate');
})->name('session.create');*/

Route::get('/session/create/form',function(){
    return view('SessionCreateForm');
})->name('session.create.form');

Route::get('/modifing', function(){
    return view('SiteModifing');
});

Route::get('/students', function(){
    return view('StudentsSheet');
});

Route::get('/user', function(){
    return view('UserModifing');
});

Route::get('/validate', function(){
    return view('ValidateLevel');
});

Route::get('/sheet', function(){
    return view('EvolutiveSheet');
});

// Route pour supprimer la session
Route::delete('/sessions/supprimer/{id}', [App\http\Controllers\SessionDelete::class, 'destroy'])->name('sessionsDelete');


// Route pour modifier une session
Route::get('/sessions/modifier/{id}', [SessionModifier::class, 'edit'])->name('sessionsModifing');

Route::get('/session/view', [App\Http\Controllers\SessionViewController::class, 'create'])->name('session.view');



// Afficher le formulaire de création
Route::get('/session/create', [App\Http\Controllers\SessionController::class, 'create'])->name('sessions.create');

// Enregistrer une nouvelle séance
Route::post('/session/create', [App\Http\Controllers\SessionController::class, 'store']);