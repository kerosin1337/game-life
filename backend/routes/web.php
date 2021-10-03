<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\AnimalController;
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

Route::prefix('game')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::post('/create', [GameController::class, 'store']);
    Route::get('/{id]', [GameController::class, 'show']);
});

Route::prefix('animal')->group(function () {
    Route::get('/', [AnimalController::class, 'index']);
    Route::post('/create', [AnimalController::class, 'create']);
    Route::post('/create_more', [AnimalController::class, 'create_more']);
});
