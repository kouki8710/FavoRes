<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoResController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StarController;

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

Route::get('/',[FavoResController::class,"index"]);

Route::resource('articles', ArticleController::class, ["only" => ["create","store","show","edit","update","destroy"]]);
Route::resource('comments', CommentController::class, ["only" => ["store","show","update","destroy"]]); // showのIDはarticle
Route::resource('stars', StarController::class, ["only" => ["store","show","update","destroy"]]); // showのIDはarticle

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard')->withViewData(["title"=>"FavoRes | Dashboard"]);
})->name('dashboard');
