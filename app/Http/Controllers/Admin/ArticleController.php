<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\article\CreateArticleRequest;
use App\Http\Requests\article\UpdateArticleRequest;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use App\Models\Article;


class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::with('categoryArticle')
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view("admin.pages.article.index", ['listArticle' => $article]);
    }

    public function create()
    {
        $categories = CategoryArticle::all();
        // Trả về view với danh sách danh mục
        return view('admin.pages.article.create', compact('categories'));
    }

    public function store(CreateArticleRequest $request)
    {
        $path = $request->file('image') ? $request->file('image')->store('images/category', 'public') : null;

        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $path,
            'content' => $request->content,
        ];

        Article::create($data);
        toastr("Chúc mừng bạn đã thêm thành công", NotificationInterface::SUCCESS, "Thêm thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("article.create");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        // Lấy danh sách danh mục
        $categories = CategoryArticle::all();
        return view("admin.pages.article.update", compact('article', 'categories'));
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        $path = $article->image;

        $validatedData['image'] = $request->hasFile('image')
            ? tap($request->file('image')->store('images/category', 'public'), function () use ($article) {
                // Xóa hình ảnh cũ nếu tồn tại
                if ($article->image && Storage::disk('public')->exists($article->image)) {
                    Storage::disk('public')->delete($article->image);
                }
            })
            : $path;

        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $validatedData['image'], // Lưu ảnh mới hoặc giữ ảnh cũ
            'content' => $request->content,
        ];

        $article->update($data);

        toastr("Chúc mừng bạn đã cập nhật thành công", NotificationInterface::SUCCESS, "Cập nhật thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route("article.index");
    }



    public function destroy(string $id)
    {
        $article = Article::find($id);
        Storage::disk('public')->delete($article->image);
        $article->delete();
        toastr("Chúc mừng bạn đã xóa thành công", NotificationInterface::SUCCESS, "Xóa thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("article.index");
    }
}
