<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['productImages', 'productVariants.attributeValues.attribute', 'categoryProduct'])->findOrFail($id);
        // dd($product);

        $productVariants = $product->toArray()['product_variants'];
        $variantResponse = [];
        $productResponse = [];

        $productAttribute = []; // danh sach bien the tra ra


        // lay danh sach attribute
        foreach ($productVariants as $key1 => $variant) {
            // lay attribute
            foreach ($variant['attribute_values'] as $key2 => $value2) {
                $productAttribute[$key2]['id'] = $value2['attribute']['id'];
                $productAttribute[$key2]['name'] = $value2['attribute']['name'];
            }
        }
        // dd($productAttribute);

        // lay danh sach gia tri cua bien the
        foreach ($productAttribute as $key1 => $attribute) {
            $attributeValue = [];
            foreach ($productVariants as $key => $variant) {
                foreach ($variant['attribute_values'] as $key2 => $value) {
                    // dd($value);
                    if ($value['attribute_id'] == $attribute['id']) {
                        $attributeValue[] = [
                            'id' => $value['id'],
                            'name' => $value['name']
                        ];
                    }
                }
            }
            // dd($attributeValue);
            // loai bo nhung phan tu trung nhau 
            $uniqueData = collect($attributeValue)->unique('id')->values()->toArray();
            // dd($uniqueData);
            $productAttribute[$key1]['value'] = $uniqueData;
        }

        // dd($productAttribute);
        // dd($product->toArray());

        // dd($productVariants);

        // lấy id danh mục sản phẩm , hiển thị sản phẩm cùng loại
        // hieen thị danh sách sản phẩm cùng loại với sản phẩm trước đó
        $categoryId = $product['category_product_id'];
        $relatedProducts = Product::where('category_product_id', $categoryId)
            ->where('id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->get();

        // dd($product->toArray());
        $productVariantJson = json_encode($productVariants);

        return view(
            'client.pages.product.index',
            compact('product', 'relatedProducts', 'productAttribute', 'productVariantJson')
        );
    }
}
