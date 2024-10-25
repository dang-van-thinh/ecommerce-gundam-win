<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['productImages', 'productVariants', 'categoryProduct'])
            ->orderBy('love', 'desc') // Sắp xếp theo trường love
            ->take(5) // Lấy 5 sản phẩm có giá trị love cao nhất
            ->get(); // Trả về danh sách sản phẩm
        return view('client.pages.home.index', compact('products'));
    }
    public function loadAllCollection() {
    }
}
