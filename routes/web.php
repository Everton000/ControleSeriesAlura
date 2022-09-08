<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Autenticador;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Mail\SeriesCreated;

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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('signin');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('/register',  [UsersController::class, 'create'])->name('users.create');
Route::post('/register',  [UsersController::class, 'store'])->name('users.store');

Route::resource('/series', SeriesController::class)
    ->except(['show']);
    
Route::middleware('autenticador')->group(function () {
    Route::get('/', function () {
        return redirect('/series');
    });

    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])
        ->name('seasons.index');

    Route::get('/seasons/{season}/episodes', [EpisodesController::class, 'index'])
        ->name('episodes.index');
    Route::post('/seasons/{season}/episodes', [EpisodesController::class, 'update'])
        ->name('episodes.update');
});

Route::get('/email', function () {
    return new SeriesCreated(
        'Série de teste',
        24,
        5,
        10
    );
});