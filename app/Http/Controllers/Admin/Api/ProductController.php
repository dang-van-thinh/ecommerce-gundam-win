<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function filter(Request $request)
    {
        $category = $request->category;
        $search = $request->search;
        $status = $request->status;  // Lấy trạng thái từ request

        try {
            $query = Product::with(['productImages', 'categoryProduct', 'productVariants'])->latest('id');

            // Lọc theo danh mục
            if ($category !== 'all') {
                $query->where('category_product_id', $category);
            }

            // Lọc theo trạng thái
            if ($status !== 'all') {
                $query->where('status', $status);
            }

            // Tìm kiếm theo mã sản phẩm hoặc tên
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                });
            }

            // Phân trang
            $products = $query->paginate(5);

            return response()->json([
                'products' => $products,
                'pagination' => [
                    'prev_page_url' => $products->previousPageUrl(),
                    'next_page_url' => $products->nextPageUrl(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
