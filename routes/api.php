<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    //Takım Rotaları
    Route::prefix('teams')->as('teams.')->group(function () {
        Route::get('/', [TeamController::class, 'index']);
        Route::get('/stats', [TeamController::class, 'stats']);
    });

    //Fikstür Rotaları
    Route::prefix('fixture')->as('fixture.')->group(function () {
        Route::get('/', [FixtureController::class, 'index'])->name('index');
        Route::post('/create', [FixtureController::class, 'store'])->name('create');
    });

    //Lig Rotaları
    Route::post('/play-match', [LeagueController::class, 'store'])->name('store');
    Route::delete('/reset', [LeagueController::class, 'destroy'])->name('destroy');

    //Tahmin Rotaları
    Route::get('/prediction', [PredictionController::class, 'index'])->name('index');
});
