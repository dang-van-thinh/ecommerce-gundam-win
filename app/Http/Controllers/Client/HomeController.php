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
         $headerBanners = Banner::where('image_type','HEADER')->get();
        $contentLeftTopBanners = Banner::where('image_type','CONTENT-LEFT-TOP')->get();
        $contentLeftBelowBanners = Banner::where('image_type','CONTENT-LEFT-BELOW')->get();
        $contentRightBanners = Banner::where('image_type','CONTENT-RIGHT')->get();
        $subscribeNowEmailBanners = Banner::where('image_type','SUBSCRIBE-NOW-EMAIL')->get();
        $leftBanners = Banner::where('image_type','BANNER-LEFT')->get();
        $rightBanners = Banner::where('image_type','BANNER-RIGHT')->get();
         
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
