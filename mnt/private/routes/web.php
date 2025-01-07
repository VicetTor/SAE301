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

Route::get('/connexion',function(){
    return view('ConnexionPage');
})->name('connexion');

Route::get('/inscription',function(){
    return view('SignInForm');
})->name('inscription');

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

