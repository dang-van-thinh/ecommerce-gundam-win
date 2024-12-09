<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Model Product để truy vấn sản phẩm
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchText = $request->input('text');

        // Truy vấn sản phẩm với eager loading và kết hợp với các bảng cần thiết
        $products = Product::with([
            'productImages',
            'productVariants.attributeValues.attribute',
            'categoryProduct'
        ])
            ->leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(CEIL(AVG(f.rating)), 0) as average_rating'),
                DB::raw('CASE WHEN SUM(pv.quantity) IS NULL OR SUM(pv.quantity) = 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('products.status', 'ACTIVE')
            ->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%")  // Tìm kiếm theo tên sản phẩm
                    ->orWhere('code', 'LIKE', "%$searchText%"); // Tìm kiếm theo mã sản phẩm
            })
            ->orWhereHas('categoryProduct', function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%");  // Tìm kiếm theo tên danh mục
            })
            ->groupBy('products.id') // Đảm bảo nhóm theo sản phẩm
            ->orderByDesc(DB::raw('COALESCE(AVG(f.rating), 0)'))
            ->get();

        // Trả về kết quả dưới dạng JSON
        return response()->json($products);
    }
}
