<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\ForumController::class, 'index'])->name('index');
Route::resource('forums', ForumController::class);
Route::resource('posts', PostController::class);
Route::post('/posts', 'App\Http\Controllers\PostController@store');
Route::resource('replies', ReplyController::class);
Route::delete('/posts/{post}', 'App\Http\Controllers\PostController@destroy');
Route::delete('/replies/{reply}', 'App\Http\Controllers\ReplyController@destroy')->name('replies.delete');