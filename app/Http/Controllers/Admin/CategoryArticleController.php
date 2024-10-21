<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\categoryArticle\UpdateCategoriArticleRequest;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categoryArticle\CreateCategoryArticleRequest;
use App\Models\CategoryArticle;

class CategoryArticleController  extends Controller
{
    public function index()
    {
        $categories = CategoryArticle::query()
            ->orderBy("id", "desc")
            ->paginate(4);
        return view("admin.pages.category.articles.index", ['listCategoryArticle' => $categories]);
    }

    public function store(CreateCategoryArticleRequest $request)
    {
        $validatedData = $request->validated();
        $cate = new CategoryArticle();
        $cate->create($validatedData);
        toastr("Thêm mới thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("category-article.index");
    }
    public function show(string $id) {}
    public function edit(string $id)
    {
        $cate = CategoryArticle::find($id);
        return view("admin.pages.category.articles.update", ["category" => $cate]);
    }
    public function update(UpdateCategoriArticleRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $cate = CategoryArticle::find($id);
        $cate->update($validatedData);
        toastr("Cập nhập thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("category-article.index");
    }
    public function destroy(string $id)
    {
        $cate = CategoryArticle::find($id);
        $cate->delete();
        toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("category-article.index");
    }
}
