<?php

use App\Http\Controllers\FormsTrainingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ModificationUserController;

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



Route::get('/connexion',[App\Http\Controllers\LoginController::class, 'create']);
Route::post('/connexion', [App\Http\Controllers\LoginController::class, 'tryConnect']);


Route::get('/inscription',function(){
    return view('SignInForm');
})->name('inscription');


Route::get('/session',function(){
    return view('SessionsPage');
})->name('session');


Route::get('/session/create',function(){
    return view('SessionCreate');
})->name('session.create');


Route::get('/session/create/form',function(){
    return view('SessionCreateForm');
})->name('session.create.form');

Route::get('/site/edit', [App\Http\Controllers\SiteController::class, 'showEditForm'])->name('modifSite');
Route::post('/site/update', [App\Http\Controllers\SiteController::class, 'updateSite'])->name('site.update');


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
Route::get('/profile',[App\Http\Controllers\ProfileController::class, 'up'])->name('infoUserUpdate');
Route::post('/pswdUserUpdate', [App\Http\Controllers\ProfileController::class, 'pswdUpdate'])->name('pswdUserUpdate');
Route::post('/profile',[App\Http\Controllers\ProfileController::class, 'up'])->name('infoUserUpdate');

Route::get('/validate', function(){
    return view('ValidateLevel');
});


Route::get('/sheet', function(){
    return view('EvolutiveSheet');
});

Route::get('/forms-training', [FormsTrainingController::class, 'show']);
Route::post('/forms-training/validate1', [FormsTrainingController::class, 'validateForms'])->name('validate.forms1');
Route::post('/forms-training/validate2', [FormsTrainingController::class, 'validateForms2'])->name('validate.forms2');

Route::get('/utilisateur/modification', [ModificationUserController::class, 'show'])->name('modification.users');
Route::get('/utilisateur/recherche', [ModificationUserController::class, 'search'])->name('modification.users.search');
Route::get('/modification/users/{id}/edit', [ModificationUserController::class, 'edit'])->name('modification.users.edit');
Route::post('/modification/users/{id}/delete', [ModificationUserController::class, 'delete'])->name('modification.users.delete');
Route::put('/modification/users/{id}/update', [ModificationUserController::class, 'update'])->name('modification.users.update');
