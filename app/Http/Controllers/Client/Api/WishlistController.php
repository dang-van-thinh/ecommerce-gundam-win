<?php

namespace App\Http\Controllers\Client\Api;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        try {
            // Xác thực dữ liệu yêu cầu
            $validated = $request->validate([
                'userId' => 'required|integer|exists:users,id',
                'product_id' => 'required|integer|exists:products,id',
            ], [
                'userId.required' => 'Người dùng là bắt buộc.',
                'userId.integer' => 'Người dùng phải là một số nguyên.',
                'userId.exists' => 'Người dùng không tồn tại trong hệ thống.',
                'product_id.required' => 'Sản phẩm là bắt buộc.',
                'product_id.integer' => 'Sản phẩm phải là một số nguyên.',
                'product_id.exists' => 'Sản phẩm không tồn tại trong hệ thống.',
            ]);

            // Lấy thông tin người dùng và sản phẩm từ yêu cầu
            $userId = $validated['userId'];
            $productId = $validated['product_id'];

            // Lấy thông tin sản phẩm
            $product = Product::find($productId);

            // Kiểm tra nếu sản phẩm không tồn tại
            if (!$product) {
                return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại.'], 404);
            }

            // Kiểm tra sản phẩm có trong danh sách yêu thích của người dùng hay không
            $favorite = Favorite::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($favorite) {
                // Nếu sản phẩm đã có trong danh sách yêu thích, xóa nó
                $favorite->delete();
                $product->decrement('love', 1); // Giảm 1 lượt yêu thích của sản phẩm

                $loveCount = Favorite::where('user_id', $userId)->count(); // Tổng số sản phẩm yêu thích của người dùng

                return response()->json([
                    'status' => 'removed',
                    'love' => $loveCount,
                    'message' => 'Sản phẩm đã được gỡ khỏi danh sách yêu thích',
                ]);
            } else {
                // Nếu sản phẩm chưa có trong danh sách yêu thích, thêm nó vào
                Favorite::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
                $product->increment('love', 1); // Tăng 1 lượt yêu thích của sản phẩm

                $loveCount = Favorite::where('user_id', $userId)->count(); // Tổng số sản phẩm yêu thích của người dùng

                return response()->json([
                    'status' => 'added',
                    'love' => $loveCount,
                    'message' => 'Sản phẩm đã được thêm vào danh sách yêu thích',
                ]);
            }
        } catch (\Exception $exception) {
            // Xử lý tất cả lỗi trong một catch
            return response()->json([
                'status' => 'error',
                'message' => $exception->errors(),
            ], 500); // Mã lỗi server lỗi (500)
        }
    }
    public function removeFavorite(Request $request)
    {
        try {
            // Xác thực dữ liệu yêu cầu
            $validated = $request->validate([
                'userId' => 'required|integer|exists:users,id',
                'favorite_id' => 'required|integer|exists:favorites,id',
            ], [
                'userId.required' => 'ID người dùng là bắt buộc.',
                'userId.integer' => 'ID người dùng phải là một số nguyên.',
                'userId.exists' => 'Người dùng không tồn tại trong hệ thống.',
                'favorite_id.required' => 'ID sản phẩm yêu thích là bắt buộc.',
                'favorite_id.integer' => 'ID sản phẩm yêu thích phải là một số nguyên.',
                'favorite_id.exists' => 'Sản phẩm yêu thích không tồn tại trong hệ thống.',
            ]);

            // Lấy thông tin sản phẩm yêu thích và người dùng từ yêu cầu
            $wishListItem = Favorite::find($validated['favorite_id']);
            $userId = $validated['userId'];

            // Kiểm tra nếu sản phẩm yêu thích tồn tại
            if ($wishListItem) {
                // Kiểm tra xem sản phẩm này có thuộc về người dùng không
                if ($wishListItem->user_id === $userId) {
                    // Xóa sản phẩm khỏi danh sách yêu thích
                    $wishListItem->delete();
                    $loveCount = Favorite::where('user_id', $userId)->count(); // Tổng số sản phẩm yêu thích của người dùng

                    return response()->json([
                        'status' => 'removed',
                        'love' => $loveCount,
                        'message' => 'Sản phẩm đã được xóa khỏi yêu thích',
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm yêu thích không thuộc về người dùng này.',
                ],); // Mã lỗi 403 (cấm truy cập)
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy sản phẩm yêu thích',
            ],); // Mã lỗi 404 (không tìm thấy)
        } catch (\Exception $exception) {
            // Xử lý tất cả lỗi trong một catch
            return response()->json([
                'status' => 'error',
                'message' => $exception->errors(),
            ], 500); // Mã lỗi server lỗi (500)
        }
    }


}

