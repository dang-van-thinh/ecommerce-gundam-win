<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with(['productImages', 'categoryProduct', 'productVariants'])
            ->latest('id')->paginate(5);

        // dd($data->toArray());
        return view('admin.pages.products.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::with('attributeValues')->get();
        $categoryProduct = CategoryProduct::pluck('name', 'id')->all();

        return view('admin.pages.products.create', compact('attributes', 'categoryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name'                => 'required|string|max:255',
            'description'         => 'required|string',
            'category_product_id' => 'required|exists:category_products,id',
            'status'              => 'required|in:ACTIVE,IN_ACTIVE',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'image_url.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'variants.*.price'    => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id,
                    'status' => $request->status,
                    'image' => $request->hasFile('image') ? Storage::put('products/images', $request->file('image')) : null,
                ]);

                // Xử lý album ảnh (nếu có)
                if ($request->hasFile('image_url')) {
                    foreach ($request->file('image_url') as $image) {
                        $imagePath = Storage::put('products/albums', $image);
                        $product->productImages()->create(['image_url' => $imagePath]);
                    }
                }

                // Lưu các biến thể của sản phẩm
                foreach ($request->variants as $variantData) {
                    // Tạo biến thể sản phẩm
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'price' => $variantData['price'],
                        'quantity' => $variantData['quantity'],
                    ]);

                    // Gắn các giá trị thuộc tính vào biến thể (nếu có)
                    if (isset($variantData['attributes'])) {
                        // Đảm bảo `attributes` là một mảng của `attribute_value_id`
                        foreach ($variantData['attributes'] as $attributeValueId) {
                            $variant->attributeValues()->attach($attributeValueId); // attach cần attribute_value_id hợp lệ
                        }
                    }
                }
            });

            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm mới thành công!');

            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        dd($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product->toArray());
        $attributes = Attribute::with('attributeValues')->get(); // Lấy các thuộc tính và giá trị
        $categoryProduct = CategoryProduct::pluck('name', 'id'); // Pluck sẽ trả về collection, không cần `all()`

        return view('admin.pages.products.edit', compact('attributes', 'categoryProduct', 'product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name'                => 'required|string|max:255',
            'description'         => 'required|string',
            'category_product_id' => 'required|exists:category_products,id',
            'status'              => 'required|in:ACTIVE,IN_ACTIVE',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'image_url.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'variants.*.price'    => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $product) {
                // Xóa ảnh cũ nếu có ảnh mới được tải lên
                if ($request->hasFile('image')) {
                    if ($product->image) {
                        Storage::delete($product->image); // Xóa ảnh cũ
                    }
                    $newImage = Storage::put('products/images', $request->file('image'));
                    $product->image = $newImage;
                }

                // Cập nhật thông tin sản phẩm
                $product->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id,
                    'status' => $request->status,
                ]);

                // Xử lý album ảnh - Xoá ảnh cũ và lưu ảnh mới
                if ($request->hasFile('image_url')) {
                    // Xóa tất cả các ảnh cũ trong album
                    foreach ($product->productImages as $productImage) {
                        Storage::delete($productImage->image_url); // Xóa ảnh album cũ
                        $productImage->delete(); // Xóa bản ghi trong DB
                    }

                    // Lưu ảnh mới vào album
                    foreach ($request->file('image_url') as $image) {
                        $imagePath = Storage::put('products/albums', $image);
                        $product->productImages()->create(['image_url' => $imagePath]);
                    }
                }

                // Cập nhật các biến thể của sản phẩm
                foreach ($request->variants as $variantData) {
                    $variant = ProductVariant::updateOrCreate(
                        ['id' => $variantData['id'] ?? null, 'product_id' => $product->id],
                        [
                            'price' => $variantData['price'],
                            'quantity' => $variantData['quantity'],
                        ]
                    );

                    // Cập nhật các giá trị thuộc tính cho biến thể (nếu có)
                    if (isset($variantData['attributes'])) {
                        $variant->attributeValues()->sync($variantData['attributes']);
                    }
                }
            });

            return back()->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Throwable $th) {
            throw $th; // Hoặc xử lý lỗi phù hợp
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Xóa ảnh chính của sản phẩm (nếu có)
            if ($product->image) {
                Storage::delete($product->image);
            }

            // Xóa các ảnh album liên quan
            foreach ($product->productImages as $productImage) {
                Storage::delete($productImage->image_url); // Xóa ảnh album khỏi storage
                $productImage->delete(); // Xóa bản ghi trong DB
            }

            // Xóa các biến thể sản phẩm (product variants)
            foreach ($product->productVariants as $variant) {
                // Xóa các giá trị thuộc tính (attribute values) liên quan đến biến thể
                $variant->attributeValues()->detach();
                $variant->delete();
            }

            // xóa sản phẩm
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Throwable $th) {
        }
    }
}
