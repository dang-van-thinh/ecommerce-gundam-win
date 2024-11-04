<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Model Product để truy vấn sản phẩm

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchText = $request->input('text');
        $products = Product::with(['productVariants'])
            ->where('name', 'LIKE', "%$searchText%")
            ->get();
        return response()->json($products);
    }
}