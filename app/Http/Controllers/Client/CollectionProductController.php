<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CollectionProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['productImages', 'categoryProduct', 'productVariants'])
            ->latest('id')->get();
        // dd($products);
        return view('client.pages.collection-product.index', compact('products'));
    }
}
