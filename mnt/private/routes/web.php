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
    return view('Home');
});

/* CONNEXION */
Route::get('/connexion',function(){
    return view('ConnexionPage');
})->name('connexion');

Route::get('/connexion',[App\Http\Controllers\LoginController::class, 'create']);
Route::post('/connexion', [App\Http\Controllers\LoginController::class, 'tryConnect']);


Route::get('/inscription',function(){
    return view('SignInForm');
})->name('inscription');


Route::get('/profile',function(){
    return view('MyProfile');
})->name('profile');

Route::post('/user', function(){
    return view('MyProfile');
});


Route::get('/session',function(){
    return view('SessionsPage');
})->name('session');


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

/* USER MODIFYING */
Route::get('/user', function(){
    return view('UserModifying');
});

Route::post('/infoUserUpdate',[App\Http\Controllers\ProfileController::class, 'infoUpdate'])->name('infoUserUpdate');
Route::post('/pswdUserUpdate', [App\Http\Controllers\ProfileController::class, 'pswdUpdate'])->name('pswdUserUpdate');


Route::get('/validate', function(){
    return view('ValidateLevel');
});


Route::get('/sheet', function(){
    return view('EvolutiveSheet');
});

