<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\categoryProduct\CreateCategoryProductRequest;
use App\Http\Requests\categoryProduct\UpdateCategoriProductRequest;
use App\Models\CategoryProduct;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $categories = CategoryProduct::orderBy("id", "desc")->paginate(4);
        return view("admin.pages.category.products.index", ['listCateProduct' => $categories]);
    }
    public function store(CreateCategoryProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $request->file('image')->store('images/category', 'public') ?? null;
        CategoryProduct::create($validatedData);
        toastr("Thêm mới thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('category-product.index');
    }
    public function edit(string $id)
    {
        $category = CategoryProduct::findOrFail($id);
        return view('admin.pages.category.products.update', ['category' => $category]);
    }
    public function update(UpdateCategoriProductRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $category = CategoryProduct::findOrFail($id);
        $validatedData['image'] = $request->hasFile('image') ? tap($request->file('image')->store('images/category', 'public'), function () use ($category) {
            Storage::disk('public')->delete($category->image); }) : $category->image;
        $category->update($validatedData);
        toastr("Cập nhập thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('category-product.index');
    }
    public function destroy(string $id)
    {
        $category = CategoryProduct::findOrFail($id);
        Storage::disk('public')->delete($category->image);
        $category->delete();
        toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->back();
    }
}
