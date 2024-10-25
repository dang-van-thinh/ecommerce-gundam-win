<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index($id)
    {
        $articles = Article::findOrFail($id);
        $latestPosts = Article::orderBy('id', 'desc')->take(4)->get();
        $categories = CategoryArticle::withCount('articles')->get();

        return view('client.pages.blog.index', compact('articles', 'latestPosts', 'categories'));
    }
    public function articlesByCategory($id)
    {
        // Lấy thể loại theo id
        $category = CategoryArticle::findOrFail($id);

        // Lấy các bài viết thuộc thể loại đó
        $articles = $category->articles()->orderBy('id', 'desc')->paginate(3);

        // Lấy các bài viết mới nhất
        $latestPosts = Article::orderBy('id', 'desc')->take(4)->get();

        // Lấy danh sách thể loại để hiển thị bên sidebar
        $categories = CategoryArticle::withCount('articles')->get();

        // Trả về view với các dữ liệu tương ứng
        return view('client.pages.collection-blog.index', compact('articles', 'latestPosts', 'categories', 'category'));
    }
}
