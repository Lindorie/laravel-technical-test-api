<?php

use App\Http\Controllers\AdministrateurController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AdministrateurController::class, 'login']);
Route::post('/register', [AdministrateurController::class, 'register']);

Route::prefix('profil')->name('profil.')->group(function () {

    // CRUD Profil
    Route::controller(ProfilController::class)->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/create', 'store')->name('store');
            Route::put('/{profil}', 'update')->name('update');
            Route::delete('/{profil}', 'destroy')->name('destroy');
        });
    });

    // Add comment to a specific profile.
    Route::post('/{profil}/add-comment', [CommentaireController::class, 'store'])->middleware('auth:sanctum')->name('add-comment');
});

// Show all profiles.
Route::get('/profils', [ProfilController::class, 'index']);
