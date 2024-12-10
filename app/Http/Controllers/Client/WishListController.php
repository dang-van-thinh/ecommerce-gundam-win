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
}
