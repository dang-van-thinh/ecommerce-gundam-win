<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['productImages', 'productVariants', 'categoryProduct'])
            ->orderBy('love', 'desc') // Sắp xếp theo trường love
            ->take(5) // Lấy 5 sản phẩm có giá trị love cao nhất
            ->get(); // Trả về danh sách sản phẩm

         // Lấy theo phân loại banner
         $headerBanners = Banner::where('image_type','HEADER')->first();
        $contentLeftTopBanners = Banner::where('image_type','CONTENT-LEFT-TOP')->first();
        $contentLeftBelowBanners = Banner::where('image_type','CONTENT-LEFT-BELOW')->first();
        $contentRightBanners = Banner::where('image_type','CONTENT-RIGHT')->first();
        $subscribeNowEmailBanners = Banner::where('image_type','SUBSCRIBE-NOW-EMAIL')->first();
        $leftBanners = Banner::where('image_type','BANNER-LEFT')->first();
        $rightBanners = Banner::where('image_type','BANNER-RIGHT')->first();
         
        return view('client.pages.home.index', compact(
            'products', 
            'headerBanners', 
            'contentLeftTopBanners', 
            'contentLeftBelowBanners', 
            'contentRightBanners', 
            'subscribeNowEmailBanners', 
            'leftBanners', 
            'rightBanners'
        ));
        
    }
    public function loadAllCollection() {
    }
}
