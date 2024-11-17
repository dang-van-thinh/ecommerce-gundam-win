<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\CategoryProduct;
use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->orderBy('love', 'desc')
            ->take(4)
            ->get();
        // dd($products->toArray());

        $averageRatings = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->orderBy('average_rating', 'desc')
            ->get();

        $newProducts = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->latest()
            ->take(4)
            ->get();

        $productNew = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->latest()
            ->get();

        $bestSellingProducts = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'), DB::raw('SUM(pv.sold) as total_sold'))
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->take(4)
            ->get();

        $blogArticles = Article::latest()->take(5)->get();

        // Lấy theo phân loại banner
        $headerBanners = Banner::where('image_type', 'HEADER')->latest()->first();
        $contentLeftTopBanners = Banner::where('image_type', 'CONTENT-LEFT-TOP')->latest()->first();
        $contentLeftBelowBanners = Banner::where('image_type', 'CONTENT-LEFT-BELOW')->latest()->first();
        $contentRightBanners = Banner::where('image_type', 'CONTENT-RIGHT')->latest()->first();
        $subscribeNowEmailBanners = Banner::where('image_type', 'SUBSCRIBE-NOW-EMAIL')->latest()->first();
        $leftBanners = Banner::where('image_type', 'BANNER-LEFT')->latest()->first();
        $rightBanners = Banner::where('image_type', 'BANNER-RIGHT')->latest()->first();

        $categoryProduct = CategoryProduct::all();

        return view('client.pages.home.index', compact(
            'products',
            'headerBanners',
            'contentLeftTopBanners',
            'contentLeftBelowBanners',
            'contentRightBanners',
            'subscribeNowEmailBanners',
            'leftBanners',
            'rightBanners',
            'categoryProduct',
            'newProducts',
            'productNew',
            'bestSellingProducts',
            'averageRatings',
            'blogArticles',
        ));
    }
    public function loadAllCollection() {}
}
