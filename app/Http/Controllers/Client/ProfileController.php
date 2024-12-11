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
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function infomation()
    {
        $dataUser = [];

        // TINH TONG GIA
        $orderData = Order::where('user_id', Auth::id())
            ->whereNotIn('status', ['PROCESSING', 'CANCELED'])
            ->select(
                DB::raw('COUNT(id) as total_orders'), // Đếm số lượng đơn hàng
                DB::raw('SUM(total_amount) as total_price') // Tính tổng giá trị của tất cả các đơn hàng
            )
            ->first(); // Lấy kết quả duy nhất
        $dataUser['totalOrder'] = $orderData->total_orders ?? 0; // Tổng số lượng đơn hàng
        $dataUser['totalPrice'] = $orderData->total_price ?? 0; // Tổng giá trị đơn hàng
        return view('client.pages.profile.information', ['dataOfUser' => $dataUser]);
    }

    public function orderHistory()
    {
        $userId = Auth::id();

        // Lấy tất cả các đơn hàng của người dùng, kèm theo các đơn hoàn hàng liên quan
        $orders = Order::with([
            'orderItems.productVariant.attributeValues.attribute',
            'orderItems.productVariant.product',
            'refund' => function ($query) {
                $query->select('id', 'order_id', 'status', 'code'); // Chọn các trường cần thiết từ bảng Refund
            },
            'refund.refundItem.productVariant.product'
        ])
            ->where('user_id', $userId)  // Chỉ lấy các đơn hàng của người dùng hiện tại
            ->orderBy('id', 'desc')  // Sắp xếp theo ID đơn hàng giảm dần
            ->get();

        // dd($orders); // Dùng để kiểm tra kết quả nếu cần

        // Trả về view với dữ liệu đơn hàng và đơn hoàn hàng
        return view('client.pages.profile.order', compact('orders'));
    }
    public function feedbackstore(FeedbackRequest $request)
    {
        // Kiểm tra xem người dùng đã đánh giá sản phẩm trong đơn hàng này chưa
        $existingFeedback = Feedback::where('order_item_id', $request->input('order_item_id'))
            ->where('user_id', $request->input('user_id'))
            ->first();

        if ($existingFeedback) {
            // Nếu đã có đánh giá rồi, trả về thông báo lỗi
            sweetalert("Bạn đã đánh giá sản phẩm này rồi.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error",
            ]);

            return back(); // Quay lại trang trước đó
        }

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
            // Kiểm tra xem đã tồn tại bản ghi chưa
            $existingUsage = VoucherUsage::where('user_id', Auth::id())
                ->where('voucher_id', $voucher->id)
                ->first();

            if (!$existingUsage) {
                // Nếu chưa có thì tạo mới
                $data = [
                    "user_id"    => Auth::id(),
                    "voucher_id" => $voucher->id,
                ];
                VoucherUsage::create($data);
            }
        }

        // Thông báo cho người dùng
        sweetalert("Cảm ơn bạn đã đánh giá sản phẩm", NotificationInterface::INFO, [
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
        $order = Order::with([
            'orderItems.productVariant.product',
            'refund.refundItem.productVariant.product',
        ])->findOrFail($id);
        // dd($order);
        // Tính tổng giá trị đơn hàng
        $totalPrice = $order->orderItems->sum(function ($item) {
            return $item->product_price * $item->quantity;
        });
        return view('client.pages.profile.layouts.components.details', compact('order', 'totalPrice'));
    }
    public function orderCancel(Request $request, $id)
    {
        // Lấy thông tin đơn hàng từ ID
        $order = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
        // dd($order->toArray());
        // huy thi cong lai so luong san pham lai vao kho
        $orderItems = $order->orderItems;
        if ($order->payment_method == "BANK_TRANSFER") {
            $order->payment_status =  "REFUNDED";
        }
        // dd($orderItems[0]->quantity);
        foreach ($orderItems as $key => $orderItem) {
            $quantity = $orderItem->productVariant->quantity;
            // dd($orderItem['product_variant']);

            $quantityNew = $quantity + $orderItem->quantity;
            $sold = $orderItem->productVariant->sold - $orderItem->quantity;
            // dd($item->productVariant->sold);
            // Cập nhật lại số lượng trong bảng product_variants
            $orderItem->productVariant->quantity = $quantityNew; // cap nhat lai so luong ton kho
            $orderItem->productVariant->sold = $sold; // cap nhat so luong da ban
            $orderItem->productVariant->save();
        }
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();

        // Kiểm tra xem lý do có được chọn hay không
        if (empty($request->cancel_reason)) {
            sweetalert("Vui lòng chọn lý do hủy đơn hàng.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error", // Thông báo lỗi
            ]);
            return back();
        }

        // Nếu lý do là "Khác", kiểm tra xem người dùng có nhập lý do không
        if ($request->cancel_reason === 'other' && empty($request->cancel_reason_other)) {
            sweetalert("Vui lòng nhập lý do khác.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error", // Thông báo lỗi
            ]);
            return back();
        }

        // Kiểm tra trạng thái của đơn hàng có cho phép hủy không
        if ($order->status === 'PENDING') {
            // Lưu lý do hủy vào cột cancel_reason hoặc cancel_reason_other
            if ($request->cancel_reason === 'other') {
                $order->cancel_reason = $request->cancel_reason;
                $order->cancel_reason_other = $request->cancel_reason_other; // Lưu lý do nhập tay
            } else {
                $order->cancel_reason = $request->cancel_reason; // Lưu lý do chọn từ danh sách
            }

            // Cập nhật trạng thái đơn hàng thành 'CANCELED'
            $order->status = 'CANCELED'; // Đảm bảo cập nhật trạng thái đơn hàng
            $order->save(); // Lưu thay đổi
            // dd($order->toArray());
            // Tăng giá trị cancel_count của người dùng (nếu cần)
            $user->increment('cancel_count', 1);

            // Thông báo hủy đơn thành công
            sweetalert("Đơn hàng của bạn đã được hủy.", NotificationInterface::INFO, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "success", // Thông báo thành công
            ]);
            // Kiểm tra ngưỡng cancel_count
            $response = $this->handleCancelThreshold($user);
            if ($response) {
                return $response; // Điều hướng nếu tài khoản bị vô hiệu hóa
            }
            // Quay lại trang trước
            return redirect()->back();
        }
        return redirect()->back();
    }
    public function orderDelete($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        // Xóa order và orderItems liên quan
        $order->orderItems()->delete();
        $order->delete();

        // Tăng giá trị cancel_count
        $user->increment('cancel_count', 1);

        // Kiểm tra ngưỡng cancel_count
        $response = $this->handleCancelThreshold($user);
        if ($response) {
            return $response; // Điều hướng nếu tài khoản bị vô hiệu hóa
        }

        sweetalert("Đơn của bạn đã được xóa", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return redirect()->route('profile.order-history');
    }

    private function handleCancelThreshold($user)
    {
        if ($user->cancel_count == 3) {
            sweetalert("Bạn đã hủy đơn hàng quá nhiều lần! Hãy cẩn thận với lần tiếp theo.", NotificationInterface::WARNING, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "warning",
            ]);
        }

        if ($user->cancel_count == 5) {
            // Chuyển trạng thái của người dùng thành IN_ACTIVE
            $user->status = 'IN_ACTIVE';
            $user->save();

            sweetalert("Tài khoản của bạn đã bị vô hiệu hóa do hủy quá nhiều đơn hàng.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error",
            ]);

            // Đăng xuất người dùng sau khi vô hiệu hóa
            Auth::logout();
            return redirect()->route('auth.login-view');
        }
    }

    public function confirmstatus($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();
        $order->status = 'COMPLETED';
        $order->confirm_status = 'ACTIVE';
        $order->payment_status = "PAID";
        $order->save();
        $user->cancel_count = 0;
        $user->save();
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
        // Kiểm tra nếu 'refund' tồn tại và là mảng
        if ($request->has('refund') && is_array($request->refund)) {
            // Kiểm tra xem đơn hàng đã có đơn hoàn hàng hay chưa
            if (Refund::where('order_id', $request->order_id)->exists()) {
                // Thông báo lỗi nếu đã có đơn hoàn hàng
                toastr("Đơn hàng này đã có đơn hoàn hàng", NotificationInterface::ERROR, "Thất bại", [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);

                return redirect()->back();
            }

            // Lấy thông tin đơn hoàn hiện tại hoặc tạo mới nếu không có
            $refund = Refund::create([
                'order_id' => $request->order_id,
                'code' => $this->codeRefund(),
            ]);

            // Cập nhật trạng thái đơn hàng thành "Đơn hoàn hàng"
            $order = Order::find($request->order_id);

            // Lặp qua từng sản phẩm trong mảng 'refund'
            foreach ($request->refund as $key => $item) {
                $imagePath = null;
                if (isset($item['image']) && $request->hasFile("refund.$key.image")) {
                    $imagePath = $request->file("refund.$key.image")->store('refund_images', 'public');
                }

                // Lưu thông tin refund item
                RefundItem::create([
                    'refund_id' => $refund->id,
                    'product_variant_id' => $item['product_variant_id'],
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
            $totalPrice = $order->orderItems->sum(function ($item) {
                return $item->product_price * $item->quantity;
            });
            return view('client.pages.profile.layouts.components.details', compact('order', 'totalPrice'));
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
