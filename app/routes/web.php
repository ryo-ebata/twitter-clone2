<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\TweetsController;
use App\Http\Controllers\UsersController;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\UsersController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function() {

    Route::resource('users', UsersController::class, ['only' => ['index', 'show', 'edit', 'update']]);
    Route::resource('tweets', TweetsController::class, ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

    Route::post('users/{user}/follow', [UsersController::class, 'follow'])->name('follow');
    Route::delete('users/{user}/unfollow', [UsersController::class, 'unfollow'])->name('unfollow');

    Route::resource('comments', CommentsController::class, ['only' => ['store']]);
    Route::resource('favorites', FavoritesController::class, ['only' => ['store', 'destroy']]);
});
