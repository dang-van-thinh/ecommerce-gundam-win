<?php

namespace App\Http\Controllers\article;

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

        $article = Article::query()
            ->orderBy('id', 'desc')
            ->paginate(4);
        return view("admin/pages/article.index", ['listArticle' => $article]);
    }

    public function create()
    {
        $categories = CategoryArticle::all();
        // Trả về view với danh sách danh mục
        return view('admin.pages.article.create', compact('categories'));
    }

    public function store(CreateArticleRequest $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newName = time() . '.' . $image->getClientOriginalExtension();

            $path = $image->storeAs('images', $newName, 'public');
        }
        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $path,
            'content' => $request->content,
        ];

        // dd($data);
        Article::create($data);

        // Chuyển hướng về trang danh sách bài viết với thông báo thành công
        return redirect()->route("article.create")->with("success", "Thêm mới thành công");
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
        // Tìm bài viết theo id
        $article = Article::findOrFail($id);

        // Giữ lại ảnh cũ nếu không upload ảnh mới
        $path = $article->image;

        if ($request->hasFile('image')) {
            // Nếu có ảnh mới, xóa ảnh cũ
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }

            // Lưu ảnh mới và ghi đè đường dẫn ảnh
            $image = $request->file('image');
            $newName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images', $newName, 'public');
        }

        // Cập nhật dữ liệu bài viết
        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $path, // Lưu ảnh mới hoặc giữ ảnh cũ
            'content' => $request->content,
        ];

        // Cập nhật thông tin bài viết trong cơ sở dữ liệu
        $article->update($data);

        // Chuyển hướng về trang danh sách bài viết với thông báo thành công
        return redirect()->route("article.index")->with("success", "Cập nhật bài viết thành công");
    }


    public function destroy(string $id)
    {
        $article = Article::find($id);
        Storage::disk('public')->delete($article->image);
        $article->delete();
        toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("article.index");
    }
}
