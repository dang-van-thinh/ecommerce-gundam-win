<?php

use App\Http\Controllers\article\ArticleController;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Route;

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

// Route::get("/home", [Controller::class, 'notification'])->name("home");
Route::get("/test", [Controller::class, 'test'])->name("test");

Route::resource('article', ArticleController::class);
