<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ImageArticleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VocuherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckOutController;
use App\Http\Controllers\Client\CollectionBlogController;
use App\Http\Controllers\Client\CollectionProductController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\WishListController;
use App\Http\Controllers\Controller;

use App\Http\Controllers\RefundController;
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

// test

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get("/home", [Controller::class, 'notification'])->name("home");
Route::get("/test", [Controller::class, 'test'])->name("test");

// admin
Route::resource('article', ArticleController::class);
Route::resource('banner', BannerController::class);
Route::resource('attributes', AttributeController::class);
Route::resource('attributeValues', AttributeValueController::class);
Route::resource('category-product', CategoryProductController::class);
Route::resource('category-article', CategoryArticleController::class);
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('voucher', VocuherController::class);
Route::resource('refund', RefundController::class);
Route::resource('products', AdminProductController::class);
Route::resource('imagearticle', ImageArticleController::class);


// client
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product');
Route::get('/collection-product', [CollectionProductController::class, 'index'])->name('collection-product');

// <!--Phần này giữ hay bỏ thì nhìn route  nhé - chọn 1 trong 2-->
Route::get('/collection-blog', [CollectionBlogController::class, 'index'])->name('collection-blog');
Route::get('/blog/{id}', [BlogController::class, 'index'])->name('blog');
// <!--->
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/wish-list', [WishListController::class, 'index'])->name('wish-list');
Route::get('/check-out', [CheckOutController::class, 'index'])->name('check-out');
Route::get('/order-success', [OrderController::class, 'index'])->name('order-success');

//profile
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'infomation'])->name('infomation');
    Route::get('/order-history', [ProfileController::class, 'orderHistory'])->name('order-history');
    Route::get('/address', [ProfileController::class, 'address'])->name('address');
});

// <!--Phần này giữ hay bỏ thì nhìn route trên của t nhé - chọn 1 trong 2-->
Route::get('/category-blog/{id}', [CollectionBlogController::class, 'articlesByCategory'])->name('category-articles');
Route::get('/blog/category-blog/{id}', [BlogController::class, 'articlesByCategory'])->name('category-blog');


// auth
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('/postlogin', [AuthController::class, 'storeLogin'])->name('login-post');
    Route::get('/register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('register-post');
    Route::get('/foget-password', [AuthController::class, 'fogetPasswordView'])->name('foget-password-view');
    Route::post('/foget-password', [AuthController::class,'checkfogetPasswordView']);
    Route::get('/verify-account/{email}', [AuthController::class, 'verify'])->name('verify-account');
});
