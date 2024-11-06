<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['productImages', 'productVariants', 'categoryProduct'])->findOrFail($id);

        // lấy id danh mục sản phẩm , hiển thị sản phẩm cùng loại
        // hieen thị danh sách sản phẩm cùng loại với sản phẩm trước đó
        $categoryId = $product->category_product_id;
        $relatedProducts = Product::where('category_product_id', $categoryId)
            ->where('id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->get();

        $feedbacks = Feedback::with(['orderItem.productVariant.product', 'user', 'replies'])
            ->whereHas('orderItem.productVariant.product', function ($query) use ($id) {
                $query->where('id', $id)->whereNull('parent_feedback_id');
            })
            ->orderBy('created_at', 'DESC')
            ->get();
        // dd($feedbacks);


        $feedbackCount = $feedbacks->count();

        // tính giá trị đánh giá trung bình của sản phẩm trả về giá trị làm tròn (1.0)
        $averageRating = $feedbacks->avg('rating');
        $averageRating = round($averageRating, 1);


        // Khởi tạo mảng để lưu tỷ lệ phần trăm cho từng mức sao
        $ratingProgress = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        // Đếm số lượng phản hồi cho mỗi mức sao
        foreach ($feedbacks as $feedback) {
            $ratingProgress[$feedback->rating]++;
        }

        // Tính tỷ lệ phần trăm cho mỗi mức sao
        foreach ($ratingProgress as $rating => $count) {
            $ratingProgress[$rating] = $feedbackCount > 0 ? round(($count / $feedbackCount) * 100) : 0;
        }

        return view(
            'client.pages.product.index',
            compact('product', 'relatedProducts', 'feedbacks', 'averageRating', 'feedbackCount', 'ratingProgress')
        );
    }
}
