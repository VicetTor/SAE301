<?php

use App\Http\Controllers\FormsTrainingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ModificationUserController;
use App\Http\Controllers\EvaluationController;

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




Route::get('/home',[App\Http\Controllers\HomeController::class, 'dataClub'])->name('home');

// Routes for login and registration
Route::get('/connexion',[App\Http\Controllers\LoginController::class, 'create'])->name('connexion'); // Show login form
Route::post('/connexion', [App\Http\Controllers\LoginController::class, 'tryConnect']); // Handle login attempt

Route::get('/inscription',[\App\Http\Controllers\SignInController::class,'show'])->name('inscription'); // Show registration form
Route::post('/inscription',[\App\Http\Controllers\SignInController::class,'signIn'])->name('inscriptionValidate'); // Handle registration form submission

// Route for user profile, renders the profile page
Route::get('/profile',function(){
    return view('MyProfile');
})->name('profile');

// Routes for the first time login process
Route::get('/firstconnexion',[\App\Http\Controllers\FirstConnexionController::class,'show'])->name('firstconnexion'); // Show the first login forms

Route::post('/firstconnexion', [App\Http\Controllers\FirstConnexionController::class, 'fill'])->name('firstconnexion'); // Update user password

// Route to display the session page
Route::get('/session',[\App\Http\Controllers\SessionController::class,'show'])->name('session');

Route::post('/user', function(){
    return view('MyProfile');
});

Route::get('/TableBilan',function(){
    return view('TableBilan');
})->name('TableBilan');

Route::get('/session/create',function(){
    return view('SessionCreate');
})->name('session.create');*/

// Route to display the form for creating a session
Route::get('/session/create/form',function(){
    return view('SessionCreateForm');
})->name('session.create.form');

// Routes for editing and updating the site details
Route::get('/site/edit', [App\Http\Controllers\SiteController::class, 'showEditForm'])->name('modifSite'); // Show site edit form
Route::post('/site/update', [App\Http\Controllers\SiteController::class, 'updateSite'])->name('site.update'); // Update site details

// Route for modifying site details page
Route::get('/modifying', function(){
    return view('SiteModifying');
});

// Route for students sheet page
Route::get('/students', function(){
    return view('StudentsSheet');
})->name('students');

// User modification routes
Route::get('/user', function(){
    return view('UserModifying');
});

// Routes for updating user information and password
Route::post('/infoUserUpdate', [App\Http\Controllers\ProfileController::class, 'infoUpdate'])->name('infoUserUpdate'); // Update user info
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'up'])->name('infoUserUpdate'); // Get user info for profile page
Route::post('/pswdUserUpdate', [App\Http\Controllers\ProfileController::class, 'pswdUpdate'])->name('pswdUserUpdate'); // Update user password
Route::post('/profile',[App\Http\Controllers\ProfileController::class, 'up'])->name('infoUserUpdate'); // Update user profile

// Route for logging out
Route::get('/logOut', [App\Http\Controllers\ProfileController::class, 'logOut'])->name('logOut');

// Home route, handles club data
Route::get('/', [App\Http\Controllers\HomeController::class, 'dataClub'])->name('');
Route::post('/', [App\Http\Controllers\HomeController::class, 'dataClub'])->name('');

// Route for validation page
Route::get('/validate', function () {
    return view('ValidateLevel');
});

// Route for the evolutive sheet
Route::get('/sheet', function () {
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

Route::get('/forms-training', [FormsTrainingController::class, 'show'])->name('forms.views.dt.creation');
Route::post('/forms-training/validate1', [FormsTrainingController::class, 'validateForms'])->name('validate.forms1');
Route::get('/formation-accueil', [FormsTrainingController::class, 'showTrainingHome']);
Route::get('/forms-modification-add', [FormsTrainingController::class, 'showUpdateTrainingAdd'])->name('forms.views.edit.responsable.add');
Route::post('/forms-modification-add', [FormsTrainingController::class, 'UpdateTraining']);
Route::get('/forms-modification-remove', [FormsTrainingController::class, 'showUpdateTrainingRemove'])->name('forms.views.edit.responsable.remove');
Route::post('/forms-modification-remove', [FormsTrainingController::class, 'RemoveTraining']);
Route::get('/training-modification-technical', [FormsTrainingController::class, 'showModificationTechnical'])->name('forms.views.edit.training.technical');
Route::post('/training-modification-technical', [FormsTrainingController::class, 'UpdateAbilities']);

// Routes for modifying user details, searching and editing users
Route::get('/modification/users', [ModificationUserController::class, 'show'])->name('modification.users'); // Show user modification page
Route::get('/modification/users/search', [ModificationUserController::class, 'search'])->name('modification.users.search'); // Search for users
Route::get('/modification/users/edit/{id}', [ModificationUserController::class, 'edit'])->name('modification.users.edit'); // Edit user details
Route::post('/modification/users/update/{id}', [ModificationUserController::class, 'update'])->name('modification.users.update'); // Update user details
Route::post('/modification/users/delete/{id}', [ModificationUserController::class, 'delete'])->name('modification.users.delete'); // Delete a user

// Routes for evaluation search and historical evaluation data
Route::get('/evaluations/search', [EvaluationController::class, 'search'])->name('evaluations.search'); // Search evaluations
Route::get('/evaluations/historique/{userId}/{clubId}', [EvaluationController::class, 'historiqueEvaluations'])->name('evaluations.historique'); // View evaluation history

// Routes for selecting year for training and exporting training data
Route::get('/select-year', [App\Http\Controllers\TrainingController::class, 'showYearSelectionForm'])->name('selectYearForm'); // Show year selection form
Route::post('/select-year', [App\Http\Controllers\TrainingController::class, 'handleYearSelection'])->name('handleYearSelection'); // Handle year selection
Route::get('/export-training-data', [App\Http\Controllers\TrainingController::class, 'exportTrainingData'])->name('exportTrainingData'); // Export training data

// Route for displaying training graph
Route::get('/training-graph', [App\Http\Controllers\TrainingController::class, 'showTrainingGraph'])->name('trainingGraph');
    
Route::get('/choixEleve', [App\Http\Controllers\StudentController::class, 'getEleves']);
Route::post('/updateEvaluation', [App\Http\Controllers\EvaluationController::class, 'updateEvaluation']);
?>
