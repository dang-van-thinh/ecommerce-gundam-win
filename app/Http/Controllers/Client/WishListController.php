<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishListController extends Controller
{
    public function index()
    {
        // Lấy các sản phẩm yêu thích của người dùng hiện tại
        $favorites = Auth::user()
            ->favorites()
            ->with(['product' => function ($query) {
                $query->with('productImages')
                    ->join('product_variants as pv', 'products.id', '=', 'pv.product_id')
                    ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
                    ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
                    ->select(
                        'products.*',
                        DB::raw('AVG(f.rating) as average_rating'), // Tính rating trung bình
                        DB::raw('CASE WHEN SUM(pv.quantity) IS NULL OR SUM(pv.quantity) = 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
                    )
                    ->groupBy('products.id'); // Nhóm theo sản phẩm
            }])
            ->orderBy('favorites.created_at', 'desc') // Sắp xếp theo thời gian yêu thích
            ->paginate(10); // Phân trang

        // dd($favorites);
        // Trả về view với dữ liệu là các sản phẩm yêu thích của người dùng
        return view('client.pages.wish-list.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
        }

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            // Xóa sản phẩm khỏi yêu thích
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Thêm sản phẩm vào yêu thích
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $product->increment('love', 1);
            return response()->json(['status' => 'added']);
        }
    }
}
