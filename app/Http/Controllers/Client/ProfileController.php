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
use App\Models\Refund;
use App\Models\RefundItem;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \App\Http\Requests\Client\refund\RefundRequest;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }

    public function orderHistory()
    {
        $userId = Auth::id();
        // Lấy tất cả các Order cùng với OrderItems và ProductVariants
        $orders = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product', 'user')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
        return view('client.pages.profile.order', compact('orders'));
    }
    public function feedbackstore(FeedbackRequest $request)
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

        $voucher = Voucher::where('type', 'SUCCESS')->first();

        if ($voucher) {
            $startDate = Carbon::now()->lt($voucher->start_date) ? $voucher->start_date : Carbon::now();

            $data = [
                "user_id"       => Auth::id(),
                "voucher_id"    => $voucher->id,
                "vourcher_code" => strtoupper(string: Str::random(8)),
                "start_date"    => $startDate,
                "end_date"      => $voucher->end_date,
                "status"        => "ACTIVE",
            ];

            VoucherUsage::create($data);
        }

        // Thông báo cho người dùng
        sweetalert("Cảm ơn bạn đã đánh giá sản phẩm ", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return back();
    }
    public function orderDetail($id)
    {
        // Lấy thông tin đơn hàng theo ID
        $order = Order::with('orderItems.productVariant.product', 'refund')->findOrFail($id);
        return view('client.pages.profile.layouts.components.details', compact('order'));
    }
    public function orderCancel($id)
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

    public function createOrderRefunds($id)
    {
        $order = Order::with('orderItems.productVariant.product')->findOrFail($id);
        // dd($order);
        return view('client.pages.profile.layouts.components.create-refunds', compact('order'));
    }

    public function storeRefunds(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'refund' => 'required|array', // Kiểm tra nếu refund là mảng
            'refund.*.reason' => 'required', // Lý do hoàn là bắt buộc
            'refund.*.description' => 'required', // Mô tả là bắt buộc
            'refund.*.quantity' => 'required|integer|min:1', // Số lượng là bắt buộc và phải là số nguyên lớn hơn 0
            'refund.*.image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Hình ảnh là bắt buộc và phải có định dạng hợp lệ
        ], [
            'refund.required' => 'Danh sách hoàn hàng không được trống.',
            'refund.*.reason.required' => 'Lý do hoàn hàng là bắt buộc.',
            'refund.*.description.required' => 'Mô tả không được bỏ trống.',
            'refund.*.quantity.required' => 'Số lượng không được bỏ trống.',
            'refund.*.quantity.integer' => 'Số lượng phải là số nguyên.',
            'refund.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'refund.*.image.required' => 'Ảnh là bắt buộc.',
            'refund.*.image.image' => 'Tệp ảnh không hợp lệ.',
            'refund.*.image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
            'refund.*.image.max' => 'Ảnh không được quá 2MB.',
        ]);

        // Kiểm tra nếu 'refund' tồn tại và là mảng
        if ($request->has('refund') && is_array($request->refund)) {
            // Lấy thông tin đơn hoàn hiện tại
            $refund = Refund::where('order_id', $request->order_id)->first();

            // Nếu không có đơn hoàn hợp lệ, tạo mới
            if (!$refund) {
                $refund = Refund::create([
                    'order_id' => $request->order_id,
                    'code' => $this->codeRefund(),
                ]);
            }

            // Cập nhật trạng thái đơn hàng thành "Đơn hoàn hàng"
            $order = Order::find($request->order_id);
            if ($order) {
                $order->update([
                    'status' => 'REFUND',
                ]);
            }

            // Lặp qua từng sản phẩm trong mảng 'refund'
            foreach ($request->refund as $key => $item) {
                // Xử lý ảnh (nếu có)
                $imagePath = null;

                // Kiểm tra và lưu ảnh từ input file
                if (isset($item['image']) && $request->hasFile("refund.$key.image")) {
                    $imagePath = $request->file("refund.$key.image")->store('refund_images', 'public');
                }
                // Lưu thông tin refund item
                RefundItem::create([
                    'refund_id' => $refund->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'reason' => $item['reason'],
                    'description' => $item['description'],
                    'img' => $imagePath,
                ]);
            }

            // Thông báo thành công
            toastr("Tạo đơn hoàn hàng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);

            return redirect()->back();
        } else {
            // Thông báo thất bại
            toastr("Tạo đơn hoàn hàng thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);

            return redirect()->back();
        }
    }


    private function codeRefund()
    {
        // Tạo một chuỗi ngẫu nhiên gồm các chữ cái viết hoa và số với độ dài 14 ký tự
        // $code = Str::upper(Str::random(14));

        $time = now()->format('YmdHis');
        // dd($time);

        // Đảm bảo chuỗi có cả số và chữ cái bằng cách trộn ký tự từ hai tập hợp riêng biệt
        $letters = Str::random(7); // Lấy 7 chữ cái ngẫu nhiên
        $numbers = substr(str_shuffle($time), 0, 7); // Lấy 4 số ngẫu nhiên

        // Gộp và xáo trộn chữ cái và số để đảm bảo vị trí ngẫu nhiên
        $mixedCode = str_shuffle($letters . $numbers);
        return strtoupper($mixedCode);
    }
}
