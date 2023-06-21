<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LiveSearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminGenreGameController;
use App\Http\Controllers\Admin\AdminGameController;
use App\Http\Controllers\Admin\AdminDeveloperController;
use App\Http\Controllers\User\ShopcartController;
use App\Http\Controllers\Shop\ShopController;
use App\Models\Game;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/contact', [HomeController::class, 'showContact'])->name('contact');
    Route::get('/about', [HomeController::class, 'showAbout'])->name('about');

    Route::prefix('shop')->group(function () {
        Route::get('/', [ShopController::class, 'index'])->name('shop');
        Route::get('/game/{id}/{title}', [ShopController::class, 'product'])->name('game-page');
    });

    Route::prefix('user')->group(function () {
        Route::resource('/shopcarts', ShopcartController::class);

        Route::get('/library', function () {
            return view('client.library');
        });
    });

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('admin');
        Route::resource('genre-game', AdminGenreGameController::class);
        Route::resource('game', AdminGameController::class);
        Route::get('/game_search', [LiveSearchController::class, 'gameSearch'])->name('game.search');
        Route::get('/genre_game_search', [LiveSearchController::class, 'genreGameSearch'])->name('genre-game.search');
        Route::prefix('developer')->group(function(){
            Route::get('/admissions', [AdminDeveloperController::class, 'allAdmission'])->name('developer.admissions');
            Route::post('/admissions/{id}', [AdminDeveloperController::class, 'controlAdmission'])->name('developer.admissions.control');
            Route::get('/admissions/download-game/{id}', [AdminDeveloperController::class, 'gameDownload'])->name('developer.admissions.game-download');
        });
    });
});








