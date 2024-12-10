<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index()
    {
        // Lấy các sản phẩm yêu thích của người dùng hiện tại
        $favorites = Auth::user()->favorites()->with('product')->orderBy('created_at', 'desc')->paginate(10);
        // dd($favorites);
        // Trả về view với dữ liệu là các sản phẩm yêu thích của người dùng
        return view('client.pages.wish-list.index', compact('favorites'));
    }
}
