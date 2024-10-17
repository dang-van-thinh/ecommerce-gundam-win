<?php

namespace App\Http\Controllers\category;

use App\Http\Requests\category\CreateCategoryProductRequest;
use App\Http\Requests\category\UpdateCategoriProductRequest;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Storage;

class ProductController extends Controller
{
    private $categoryProduct;
    public function __construct()
    {
        $this->categoryProduct = [];
    }
    public function index()
    {
        $categories = CategoryProduct::query()
        ->orderBy("id","desc")
        ->paginate(4);
        $this->categoryProduct['listCateProduct'] = $categories;
        return view("admin.pages.category.products.index", $this->categoryProduct);
    }
    public function create()
    {

    }
    public function store(CreateCategoryProductRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('images/category', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }
        $category = new CategoryProduct();
        $category->fill($validatedData);
        $category->save();
        return redirect()->route('categoryproduct.index')->with('success', 'Thêm mới danh mục sản phẩm thành công!');
    }
    public function show(string $id)
    {

    }
    public function edit(string $id)
    {
        $category = CategoryProduct::find($id);
        return view('admin/pages/category/products.update', ['category' => $category]);
    }
    public function update(UpdateCategoriProductRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $category = CategoryProduct::find($id);
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $validatedData['image'] = $request->file('image')->storeAs('images/category', $imageName, 'public');
        }
        $category->update($validatedData);

        return redirect()->route('categoryproduct.index')->with('success', 'Cập nhật danh mục sản phẩm thành công!');
    }

    public function destroy(string $id)
    {
        $category = CategoryProduct::find($id);
        $imagePath =  $category->image;
        Storage::disk('public')->delete($imagePath);
        $category->delete();
        return redirect()->back()->with('success', 'Danh mục đã được xóa thành công.');

    }

}
