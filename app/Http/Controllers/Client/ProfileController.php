<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Feedback\EditFeedbackRequest;
use App\Http\Requests\Client\Feedback\FeedbackRequest;
use App\Http\Requests\Client\profiles\EditProfileRequest;
use App\Models\District;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }

    public function orderHistory()
    {
        // Lấy tất cả các Order cùng với OrderItems và ProductVariants
        $orders = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->get();
        return view('client.pages.profile.order', compact('orders'));
    }

    public function orderDetails($orderId)
    {
        $order = Order::with('orderItems.productVariant.product.feedback', 'orderItems.feedback')->find($orderId); // Lấy feedback qua productVariant

        return view('client.pages.profile.layouts.components.details', compact('order'));
    }

    public function store(FeedbackRequest $request)
    {
        // Tạo mới feedback
        $feedback = new Feedback();
        $feedback->order_item_id = $request->input('order_item_id');
        $feedback->user_id = $request->input('user_id');
        $feedback->rating = $request->input('rating');
        $feedback->comment = $request->input('comment');
        $feedback->updated_at = NULL;

        // Xử lý file tải lên (nếu có)
        if ($request->hasFile('file_path')) {
            $feedback->file_path = $request->file('file_path')->store('feedbacks'); // Lưu tệp vào thư mục feedbacks
        } else {
            $feedback->file_path = null; // Thiết lập giá trị là null nếu không có tệp
        }

        // Lưu feedback vào cơ sở dữ liệu
        $feedback->save();
        // Thông báo cho người dùng
        sweetalert("Cảm ơn bạn đã đánh giá sản phẩm", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return back();
    }

    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        $item = OrderItem::with('productVariant.product')->findOrFail($feedback->order_item_id);

        return view('your-view-file', compact('feedback', 'item'));
    }
    public function show($id)
    {
        // Lấy thông tin đơn hàng theo ID
        $order = Order::with('orderItems.productVariant.product')->findOrFail($id);
        return view('client.pages.profile.layouts.components.details', compact('order'));
    }

    public function update(EditFeedbackRequest $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->order_item_id = $request->input('order_item_id');
        $feedback->user_id = $request->input('user_id');
        $feedback->rating = $request->input('rating');
        $feedback->comment = $request->input('comment');
        $feedback->updated_at = now();

        // Xóa ảnh cũ nếu có ảnh mới được tải lên
        if ($request->hasFile('file_path')) {
            if ($feedback->file_path) {
                Storage::delete($feedback->file_path); // Xóa file cũ nếu có
            }
            $feedback->file_path = $request->file('file_path')->store('feedbacks');
        }

        $feedback->save();

        sweetalert("Sửa đánh giá sản phẩm thành công", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return redirect()->back();
    }
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
            $order->status = 'CANCELED';
            $order->save();
            sweetalert("Đơn của bạn đã được hủy", NotificationInterface::INFO, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "success",
            ]);
        return redirect()->back();
    }
    public function confirmstatus($id)
    {
        $order = Order::findOrFail($id);
            $order->status = 'COMPLETED';
            $order->confirm_status = 'ACTIVE';
            $order->save();

        sweetalert("Cảm ơn bạn đã xác nhận", NotificationInterface::INFO, [
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
    public function editProfile(EditProfileRequest $request)
    {
        $id = Auth::user()->id; // Lấy id tài khoản đang đăng nhập
        $user = User::find($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('users', $request->file('image'));
        }

        $imagePath = $user->image;

        $user->update($data);

        if (
            $request->hasFile('image')
            && !empty($imagePath)
            && Storage::exists($imagePath)
        ) {
            Storage::delete($imagePath);
        }
        toastr("Cập nhật thông tin hồ sơ thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return back();
    }
}
