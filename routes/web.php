<?php



use App\Http\Controllers\BannerController;
use App\Http\Controllers\attributes\AttributeController;
use App\Http\Controllers\attributes\AttributeValueController;
use App\Http\Controllers\category\ArticleController;
use App\Http\Controllers\category\ProductController;

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VocuherController;

use App\Http\Controllers\Controller;
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

Route::resource('banner', BannerController::class);
Route::resource('attributes', AttributeController::class);
Route::resource('attributeValues', AttributeValueController::class);
Route::resource('category-product', ProductController::class);
Route::resource('category-article', ArticleController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('voucher', VocuherController::class);
<<<<<<< HEAD
=======

>>>>>>> 480cd2c7c6fdddb6de32b5a93eaa60b510e428f9
