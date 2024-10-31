<?php

use App\Http\Controllers\Admin\Api\ImageBlogApiController;
use App\Http\Controllers\Client\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// ajax them moi anh bai viet
Route::post('/image-blog', [ImageBlogApiController::class, 'store'])->name('api.image');

Route::post('/add-cart', [ProductController::class, 'addToCart'])->name('api.add-cart');
Route::delete('/delete-cart', [ProductController::class, 'deleteToCart'])->name('api.delete-cart');
Route::put('/update-cart', [ProductController::class, 'updateToCart'])->name('api.update-cart');
