<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Feedback\EditFeedbackRequest;
use App\Http\Requests\Client\Feedback\FeedbackRequest;
use App\Models\District;
use App\Models\Feedback;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Storage;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }


    public function orderHistory()
    {
        // Lấy tất cả các OrderItem cùng với các mối quan hệ cần thiết
        $history = OrderItem::with('productVariant.attributeValues.attribute', 'productVariant.product', 'order', 'order.feedbacks')->get();

        // Cập nhật feedback_status cho tất cả OrderItem có feedback mới
        foreach ($history as $item) {
            if ($item->order->feedbacks()->where('user_id', auth()->id())->exists()) {
                $item->feedback_status = 1; // Đánh giá đã được tạo
                $item->save(); // Lưu thay đổi vào cơ sở dữ liệu
            }
        }

        return view('client.pages.profile.order', compact('history'));
    }



public function store(FeedbackRequest $request)
{
    // Tạo mới feedback
    $feedback = new Feedback();
    $feedback->product_id = $request->input('product_id');
    $feedback->user_id = $request->input('user_id');
    $feedback->rating = $request->input('rating');
    $feedback->comment = $request->input('comment');
    $feedback->has_edited = true;

    // Xử lý file tải lên (nếu có)
    if ($request->hasFile('file_path')) {
        $feedback->file_path = $request->file('file_path')->store('feedbacks'); // Lưu tệp vào thư mục feedbacks
    } else {
        $feedback->file_path = null; // Thiết lập giá trị là null nếu không có tệp
    }

    // Lưu feedback vào cơ sở dữ liệu
    $feedback->save();

    // Ghi nhật các giá trị order_id và product_variant_id
    \Log::info('Order ID: ' . $request->input('order_id'));
    \Log::info('Product Variant ID: ' . $request->input('product_variant_id'));

    // Cập nhật trạng thái feedback trong bảng order_items
    $orderItem = OrderItem::where('order_id', $request->input('order_id'))
        ->where('product_variant_id', $request->input('product_variant_id'))
        ->first();

    // Ghi nhật thông tin về orderItem
    if ($orderItem) {
        $orderItem->feedback_status = 1; // Đánh giá đã được tạo
        $orderItem->save(); // Lưu thay đổi vào cơ sở dữ liệu
    } else {
        \Log::warning('Order Item not found.');
    }

    // dd($orderItem); // Kiểm tra giá trị của orderItem

    // Thông báo cho người dùng
    sweetalert("Cảm ơn bạn đã đánh giá sản phẩm", NotificationInterface::INFO, [
        'position' => "center",
        'timeOut' => '',
        'closeButton' => false,
        'icon' => "success",
    ]);

    return back();
}

    public function update(EditFeedbackRequest $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->rating = $request->input('rating');
        $feedback->comment = $request->input('comment');
         $feedback->has_edited = 2;

        // Xóa ảnh cũ nếu có ảnh mới được tải lên
        $request->hasFile('file_path') && ($feedback->file_path && Storage::delete($feedback->file_path)); // Xóa file cũ nếu có

        // Lưu ảnh mới nếu có
        $feedback->file_path = $request->hasFile('file_path') ? $request->file('file_path')->store('feedbacks') : $feedback->file_path;

        $feedback->save();

        sweetalert("Sửa đánh đánh giá sản phẩm thành công", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);
        return redirect()->back();
    }

    public function address()
    {
        $user_id = User::where('user_id')->get();
        $provinces = Province::all();
        $districts = District::where('province_id')->get();
        $wards = Ward::where('district_id')->get();

        return view('client.pages.profile.address', compact('provinces', 'districts', 'wards', 'user_id'));
    }
}
