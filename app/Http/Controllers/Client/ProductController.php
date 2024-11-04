<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['productImages', 'productVariants', 'categoryProduct'])->findOrFail($id);

        // lấy id danh mục sản phẩm , hiển thị sản phẩm cùng loại
        // hieen thị danh sách sản phẩm cùng loại với sản phẩm trước đó
        $categoryId = $product->category_product_id;
        $relatedProducts = Product::where('category_product_id', $categoryId)
            ->where('id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->get();
        return view(
            'client.pages.product.index',
            compact('product', 'relatedProducts')
        );
    }
}
