<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['productImages', 'productVariants', 'categoryProduct'])->findOrFail($id);

        // lấy id danh mục sản phẩm , hiển thị sản phẩm cùng loại
        $categoryId = $product->category_product_id;

        $variant = $product->productVariants()->with('attributeValues.attribute')->first();

        //Câu lệnh SQL trả về một danh sách các giá trị thuộc tính của biến thể sản phẩm cho một sản phẩm cụ thể 
        //(được xác định bởi $id của sản phẩm đó).
        $attributes = DB::select("
            SELECT 
                pav.attribute_value_id, 
                av.name AS attribute_value_name, 
                a.name AS attribute_name,
                pv.quantity -- Thêm trường quantity để lấy số lượng
            FROM 
                product_attribute_values AS pav
            JOIN 
                attribute_values AS av ON pav.attribute_value_id = av.id
            JOIN 
                attributes AS a ON av.attribute_id = a.id
            JOIN 
                product_variants AS pv ON pav.product_variant_id = pv.id
            WHERE 
                pv.product_id = ? ", [$id]);


        // hieen thị danh sách sản phẩm cùng loại với sản phẩm trước đó 
        $relatedProducts = Product::with(['productImages', 'productVariants'])
            ->where('category_product_id', $categoryId)
            ->where('id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->get();

        return view(
            'client.pages.product.index',
            compact('product', 'relatedProducts', 'variant', 'attributes')
        );
    }
}
