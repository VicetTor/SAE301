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

// Authentication routes
// These routes handle login and registration
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Routes accessible without 'auth:sanctum' middleware (public routes)
Route::get('/trainings', [TrainingController::class, 'index']); // Get all trainings
Route::get('/trainings/{id}', [TrainingController::class, 'show']); // Get a specific training by ID
Route::post('/trainings', [TrainingController::class, 'store']); // Create a new training
Route::put('/trainings/{id}', [TrainingController::class, 'update']); // Update a specific training by ID
Route::delete('/trainings/{id}', [TrainingController::class, 'destroy']); // Delete a specific training by ID

Route::get('/session-types', [SessionTypeController::class, 'index']); // Get all session types
Route::get('/session-types/{id}', [SessionTypeController::class, 'show']); // Get a specific session type by ID
Route::post('/session-types', [SessionTypeController::class, 'store']); // Create a new session type
Route::put('/session-types/{id}', [SessionTypeController::class, 'update']); // Update a specific session type by ID
Route::delete('/session-types/{id}', [SessionTypeController::class, 'destroy']); // Delete a specific session type by ID

Route::get('/skills', [SkillController::class, 'index']); // Get all skills
Route::get('/skills/{id}', [SkillController::class, 'show']); // Get a specific skill by ID
Route::post('/skills', [SkillController::class, 'store']); // Create a new skill
Route::put('/skills/{id}', [SkillController::class, 'update']); // Update a specific skill by ID
Route::delete('/skills/{id}', [SkillController::class, 'destroy']); // Delete a specific skill by ID

Route::get('/levels', [LevelController::class, 'index']); // Get all levels
Route::get('/levels/{id}', [LevelController::class, 'show']); // Get a specific level by ID
Route::post('/levels', [LevelController::class, 'store']); // Create a new level
Route::put('/levels/{id}', [LevelController::class, 'update']); // Update a specific level by ID
Route::delete('/levels/{id}', [LevelController::class, 'destroy']); // Delete a specific level by ID

Route::get('/abilities', [AbilityController::class, 'index']); // Get all abilities
Route::get('/abilities/{id}', [AbilityController::class, 'show']); // Get a specific ability by ID
Route::post('/abilities', [AbilityController::class, 'store']); // Create a new ability
Route::put('/abilities/{id}', [AbilityController::class, 'update']); // Update a specific ability by ID
Route::delete('/abilities/{id}', [AbilityController::class, 'destroy']); // Delete a specific ability by ID

Route::get('/validations', [ValidationController::class, 'index']); // Get all validations
Route::get('/validations/{id}', [ValidationController::class, 'show']); // Get a specific validation by ID
Route::post('/validations', [ValidationController::class, 'store']); // Create a new validation
Route::put('/validations/{id}', [ValidationController::class, 'update']); // Update a specific validation by ID
Route::delete('/validations/{id}', [ValidationController::class, 'destroy']); // Delete a specific validation by ID

Route::get('/clubs', [ClubController::class, 'index']); // Get all clubs
Route::get('/clubs/{id}', [ClubController::class, 'show']); // Get a specific club by ID
Route::post('/clubs', [ClubController::class, 'store']); // Create a new club
Route::put('/clubs/{id}', [ClubController::class, 'update']); // Update a specific club by ID
Route::delete('/clubs/{id}', [ClubController::class, 'destroy']); // Delete a specific club by ID

// Routes protected by authentication ('auth:sanctum' middleware)
// These routes require the user to be authenticated using Sanctum token
Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']); // Get all users (authenticated users only)
Route::middleware('auth:sanctum')->get('/users/{id}', [UserController::class, 'show']); // Get a specific user by ID (authenticated users only)
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'showAuthenticatedUser']); // Get the currently authenticated user

?>
