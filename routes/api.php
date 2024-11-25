<?php

use App\Http\Controllers\Admin\Api\ImageBlogApiController;
use App\Http\Controllers\Admin\Api\NotificationApiController;
use App\Http\Controllers\Admin\Api\OrderController;
use App\Http\Controllers\Admin\Api\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Api\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Client\Api\AddressApiController;
use App\Http\Controllers\Client\Api\ProductController;
use App\Http\Controllers\Client\Api\VoucherController;
use App\Http\Controllers\Client\Api\WishlistController;
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

Route::prefix('')->middleware(['authApi'])->group(function () {

    // ajax them moi anh bai viet
    Route::post('/image-blog', [ImageBlogApiController::class, 'store'])->name('api.image');

    Route::post('/add-cart', [ProductController::class, 'addToCart'])->name('api.add-cart');
    Route::delete('/delete-cart', [ProductController::class, 'deleteToCart'])->name('api.delete-cart');
    Route::put('/update-cart', [ProductController::class, 'updateToCart'])->name('api.update-cart');

    Route::post('/buy-now', [ProductController::class, 'productBuyNow'])->name('api.buy-now');
    Route::post('/product/buy-now', [ProductController::class, 'getPrductVariant'])->name('api.product-variant');
    // api dia chi tinh thanh viet nam
    Route::get('get-districts/{province_id}', [AddressApiController::class, 'getDistricts'])->name('api.districts');
    Route::get('get-wards/{district_id}', [AddressApiController::class, 'getWards'])->name('api.wards');

    Route::post('/profile/address/set-default/{id}', [AddressApiController::class, 'setDefaultAddress'])->name('api.profile.address.setDefault');
    Route::post('/toggle-favorite', [WishListController::class, 'toggleFavorite'])->name('toggle.favorite');
    Route::delete('/remove-favorite', [WishListController::class, 'removeFavorite'])->name('remove.favorite');
    Route::post('/voucher/check', [VoucherController::class, 'checkVoucher']);
    Route::post('/voucher/apply', [VoucherController::class, 'applyVoucher']);
    Route::post('voucher/usage-check', [VoucherController::class, 'checkVoucherUsage']);
});


Route::prefix('admin')->middleware(['authApi'])->group(function () {
    Route::get('/orders/filter', [OrderController::class, 'filter']);
    Route::get('/users/filter', [UserController::class, 'filter']);
    Route::get('/products/filter', [AdminProductController::class, 'filter']);
});
Route::get("/chat/search-user", [UserController::class, "searchUserChat"]);
// notification public channel
Route::get("/notification", [NotificationApiController::class, "notifications"])->name("notication");
Route::put("/notification/update", [NotificationApiController::class, "updateReadNotification"]);

// chat
Route::post("/chat-send", [ChatController::class, "send"]);
Route::get("/chat-messages", [ChatController::class, "allChatOfMe"]);
Route::delete("/chat-messages", [ChatController::class, "deleteMessage"]);
Route::get("/chat-users", [UserController::class, 'getAllUser']);
