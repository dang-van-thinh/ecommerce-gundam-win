<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Order\PlaceOrderException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, $id)
    {
        try {
            // Lấy tất cả dữ liệu từ URL
            $requestData = $request->all();

            // dd(count($requestData));
            // kiem tra don hang that bai
            if (count($requestData) != 0) {

                // Kiểm tra và xác thực chữ ký (signature)
                $signature = $requestData['signature'];
                unset($requestData['signature']); // Xóa chữ ký khỏi dữ liệu

                // Tạo chuỗi rawHash để tính toán chữ ký từ các tham số
                $rawHash =
                    "accessKey=" . env('MOMO_ACCESS_KEY') .
                    "&amount=" . $requestData['amount'] .
                    "&orderId=" . $requestData['orderId'] .
                    "&orderInfo=" . $requestData['orderInfo'] .
                    "&partnerCode=" . env("MOMO_PARTNER_CODE") .
                    "&requestId=" . $requestData['requestId'] .
                    "&requestType=" . $requestData['orderType'] .
                    "&resultCode=" . $requestData['resultCode'] .
                    "&message=" . $requestData['message'];

                $secretKey = env('MOMO_SECRET_KEY'); // Lấy secret key từ môi trường

                // Tính toán chữ ký từ rawHash
                $calculatedSignature = hash_hmac('sha256', $rawHash, $secretKey);
                $signature = hash_hmac("sha256", $rawHash, $secretKey);
                // dd($secretKey, $rawHash, $signature, $calculatedSignature);
                // Kiểm tra chữ ký
                if ($signature !== $calculatedSignature) {
                    return response()->json(['error' => 'Invalid signature'], 400);
                }
                // neu giao dịch thanh cong thi doi trang thi don hang va thay doi so luong trong kho
                if ($requestData['resultCode']  == 0) { // ==0 thi la dung , khac 0 cho cook
                    $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);

                    $orderItems = $data->orderItems;
                    // dd($orderItems);
                    foreach ($orderItems as $key => $orderItem) {
                        $quantity = $orderItem->productVariant->quantity;
                        // dd($orderItem['product_variant']);
                        if ($quantity > 0 && $orderItem->quantity <= $quantity) {
                            $quantityNew = $quantity - $orderItem->quantity;
                            $sold = $orderItem->productVariant->sold + $orderItem->quantity;
                            // dd($item->productVariant->sold);
                            // Cập nhật lại số lượng trong bảng product_variants
                            $orderItem->productVariant->quantity = $quantityNew; // cap nhat lai so luong ton kho
                            $orderItem->productVariant->sold = $sold; // cap nhat so luong da ban
                            $orderItem->productVariant->save();
                        } else {
                            throw new PlaceOrderException('Số lượng sản phẩm mua không phù hợp với sản phẩm trong kho !');
                        }
                    }

                    $data->status = 'PENDING';
                    $data->save();

                    return view('client.pages.order-success.index', compact('data'));
                }


                return redirect()->route("profile.order-history"); // thay bang trang thanh toan loi

            } else {
                $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
                return view('client.pages.order-success.index', compact('data'));
            }
        } catch (\Throwable $th) {
            if ($th instanceof PlaceOrderException) {
                sweetalert($th->getMessage(), NotificationInterface::ERROR, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false
                ]);
                return redirect()->route("profile.order-history");
            }
        }
    }
}
