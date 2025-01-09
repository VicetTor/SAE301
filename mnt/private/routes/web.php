<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/connexion',[App\Http\Controllers\LoginController::class, 'create']);
Route::post('/connexion', [App\Http\Controllers\LoginController::class, 'tryConnect']);

Route::get('/inscription',function(){
    return view('SignInForm');
})->name('inscription');

Route::get('/profile',function(){
    return view('MyProfile');
})->name('profile');

Route::get('/session',function(){
    return view('SessionsPage');
})->name('session');

Route::get('/TableBilan',function(){
    return view('TableBilan');
})->name('TableBilan');


Route::get('/session/create',function(){
    return view('SessionCreate');
})->name('session.create');

Route::get('/session/create/form',function(){
    return view('SessionCreateForm');
})->name('session.create.form');

Route::get('/modifing', function(){
    return view('SiteModifing');
});

Route::get('/students', function(){
    return view('StudentsSheet');
})->name('students');;

Route::get('/user', function(){
    return view('UserModifing');
});

Route::get('/validate', function(){
    return view('ValidateLevel');
});

Route::get('/sheet', function(){
    return view('EvolutiveSheet');
});

Route::get('/choixEleve', [App\Http\Controllers\StudentController::class, 'getEleves']);
Route::post('/updateEvaluation', [App\Http\Controllers\EvaluationController::class, 'updateEvaluation']);
