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

Route::get('/inscription',[\App\Http\Controllers\SignInController::class,'show'])->name('inscription');
Route::post('/inscription',[\App\Http\Controllers\SignInController::class,'signIn'])->name('inscriptionValidate');

Route::get('/profile',function(){
    return view('MyProfile');
})->name('profile');

Route::get('/session',[\App\Http\Controllers\SessionController::class,'show'])->name('session');

Route::get('/session/create',function(){
    return view('SessionCreate');
})->name('session.create');

Route::get('/session/create/form',function(){
    return view('SessionCreateForm');
})->name('session.create.form');


Route::get('/modifying', function(){
    return view('SiteModifying');
});

Route::get('/students', function(){
    return view('StudentsSheet');
})->name('students');;

Route::get('/user', function(){
    return view('UserModifying');
});

Route::post('/user', function(){
    return view('MyProfile');
});


Route::get('/validate', function(){
    return view('ValidateLevel');
});


Route::get('/sheet', function(){
    return view('EvolutiveSheet');
});

