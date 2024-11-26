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
        // 1. Query $products
        $products = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'), // Đánh giá trung bình
                DB::raw('CASE WHEN SUM(pv.quantity) <= 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('status', 'ACTIVE')
            ->groupBy('products.id')
            ->orderBy('love', 'desc') // Sắp xếp theo yêu thích
            ->orderByDesc('products.created_at') // Sắp xếp theo ngày tạo
            ->take(4)
            ->get();

        // 2. Query $averageRatings
        $averageRatings = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('AVG(f.rating) as average_rating'),
                DB::raw('CASE WHEN SUM(pv.quantity) <= 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('status', 'ACTIVE')
            ->groupBy('products.id')
            ->orderBy('average_rating', 'desc')
            ->get();

        // 3. Query $newProducts
        $newProducts = Product::leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('AVG(f.rating) as average_rating'),
                DB::raw('CASE WHEN SUM(pv.quantity) <= 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('status', 'ACTIVE')
            ->groupBy('products.id')
            ->latest()
            ->take(4)
            ->get();

        // 4. Query $productNew
        $productNew = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('AVG(f.rating) as average_rating'),
                DB::raw('CASE WHEN SUM(pv.quantity) <= 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('status', 'ACTIVE')
            ->groupBy('products.id')
            ->latest()
            ->get();
        // dd($productNew);

        // 5. Query $bestSellingProducts
        $bestSellingProducts = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'), // Đánh giá trung bình
                DB::raw('COALESCE(SUM(pv.sold), 0) as total_sold'), // Tổng sản phẩm đã bán
                DB::raw('CASE WHEN SUM(pv.quantity) <= 0 THEN 1 ELSE 0 END as is_out_of_stock') // Kiểm tra hết hàng
            )
            ->where('status', 'ACTIVE')
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
