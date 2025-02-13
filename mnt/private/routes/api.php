<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\{
    TrainingController,
    SessionTypeController,
    SkillController,
    LevelController,
    AbilityController,
    ValidationController,
    ClubController,
    UserController,
};

// Routes d'authentification
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Routes accessibles sans middleware 'auth:sanctum'
Route::get('/trainings', [TrainingController::class, 'index']);
Route::get('/trainings/{id}', [TrainingController::class, 'show']);
Route::post('/trainings', [TrainingController::class, 'store']);
Route::put('/trainings/{id}', [TrainingController::class, 'update']);
Route::delete('/trainings/{id}', [TrainingController::class, 'destroy']);

Route::get('/session-types', [SessionTypeController::class, 'index']);
Route::get('/session-types/{id}', [SessionTypeController::class, 'show']);
Route::post('/session-types', [SessionTypeController::class, 'store']);
Route::put('/session-types/{id}', [SessionTypeController::class, 'update']);
Route::delete('/session-types/{id}', [SessionTypeController::class, 'destroy']);

Route::get('/skills', [SkillController::class, 'index']);
Route::get('/skills/{id}', [SkillController::class, 'show']);
Route::post('/skills', [SkillController::class, 'store']);
Route::put('/skills/{id}', [SkillController::class, 'update']);
Route::delete('/skills/{id}', [SkillController::class, 'destroy']);

Route::get('/levels', [LevelController::class, 'index']);
Route::get('/levels/{id}', [LevelController::class, 'show']);
Route::post('/levels', [LevelController::class, 'store']);
Route::put('/levels/{id}', [LevelController::class, 'update']);
Route::delete('/levels/{id}', [LevelController::class, 'destroy']);

Route::get('/abilities', [AbilityController::class, 'index']);
Route::get('/abilities/{id}', [AbilityController::class, 'show']);
Route::post('/abilities', [AbilityController::class, 'store']);
Route::put('/abilities/{id}', [AbilityController::class, 'update']);
Route::delete('/abilities/{id}', [AbilityController::class, 'destroy']);

Route::get('/validations', [ValidationController::class, 'index']);
Route::get('/validations/{id}', [ValidationController::class, 'show']);
Route::post('/validations', [ValidationController::class, 'store']);
Route::put('/validations/{id}', [ValidationController::class, 'update']);
Route::delete('/validations/{id}', [ValidationController::class, 'destroy']);

Route::get('/clubs', [ClubController::class, 'index']);
Route::get('/clubs/{id}', [ClubController::class, 'show']);
Route::post('/clubs', [ClubController::class, 'store']);
Route::put('/clubs/{id}', [ClubController::class, 'update']);
Route::delete('/clubs/{id}', [ClubController::class, 'destroy']);

// Routes protégées par authentification
Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->get('/users/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'showAuthenticatedUser']);

?>
