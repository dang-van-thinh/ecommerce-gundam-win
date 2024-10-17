<?php

namespace App\Http\Controllers\category;

use App\Http\Requests\category\CreateCategoryArticleRequest;
use App\Http\Requests\category\UpdateCategoriArticleRequest;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private $categoryArticle;
    public function __construct()
    {
        $this->categoryArticle = [];
    }
    public function index()
    {

        $categories = CategoryArticle::query()
        ->orderBy("id","desc")
        ->paginate(4);
        $this->categoryArticle['listCategoryArticle'] = $categories;
        return view("admin/pages/category/articles.index", $this->categoryArticle);
    }
    public function create()
    {

    }
    public function store(CreateCategoryArticleRequest $request)
    {
        $validatedData = $request->validated();
        $cate = new CategoryArticle();
        $cate->fill( $validatedData );
        $cate->save();
        return redirect()->route("categoryarticle.index")->with("success","Thêm mới thành công");
    }
    public function show(string $id)
    {

    }
    public function edit(string $id)
    {
        $cate = CategoryArticle::find($id);
        return view("admin/pages/category/articles.update", ["category"=> $cate]);
    }
    public function update(UpdateCategoriArticleRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $cate = CategoryArticle::find($id);
        $cate->fill( $validatedData );
        $cate->save();
        return redirect()->route("categoryarticle.index")->with("success","Sửa thành công sản phẩm");
    }
    public function destroy(string $id)
    {
        $cate = CategoryArticle::find($id);
        $cate->delete();
        return redirect()->route("categoryarticle.index")->with("success","Xóa thành công");
    }
}
