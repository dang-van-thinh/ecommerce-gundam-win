<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\placeOrder\CreatePlaceOrderRequest;
use App\Models\AddressUser;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    public function index()
    {

        $userId = Auth::id();
        $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get()->toArray();
        // dd($productCarts);
        $productResponse = [];
        foreach ($productCarts as $key => $value) {
            $productResponse[$key] = [];
            foreach ($productCarts as $key => $productCart) {
                $productResponse[$key]['cart'] = $productCart;
                $productResponse[$key]['product_variant'] = $productCart['product_variant'];
                $productResponse[$key]['product'] = $productCart['product_variant']['product'];
            }
        }
        // dd($productResponse);
        $userAddress = AddressUser::where('user_id', $userId)->get();

        return view('client.pages.check-out.index', [
            'productResponse' => $productResponse,
            'userAddress' => $userAddress
        ]);
    }

    public function placeOrder(CreatePlaceOrderRequest $request)
    {
        $userId = Auth::id();
        $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get();
        foreach ($productCarts as $key => $item) {
            $quantity = $item->productVariant->quantity - $item->quantity;
            // Cập nhật lại số lượng trong bảng product_variants
            $item->productVariant->update(['quantity' => $quantity]);
        }
        // Kiểm tra kết quả sau khi cập nhật
        $productCarts = $productCarts->toArray();
        // dd($productCarts);

        // dd($request->totalAmount);

        try {
            DB::beginTransaction();

            $dataOrder = [
                "address_user_id" => $request->address_user_id,
                "total_amount" => $request->total_amount,
                "payment_method" => $request->payment_method,
                "note" => $request->note,
                "confirm_status" => "IN_ACTIVE",
                "status" => "PENDING"
            ];
            $order = Order::create($dataOrder);

            $data = [];
            foreach ($productCarts as $key => $item) {
                $data[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'product_name' => $item['product_variant']['product']['name'],
                    'product_price' => $item['product_variant']['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['quantity'] * $item['product_variant']['price']
                ];
            }

            OrderItem::insert($data);

            // Xóa các sản phẩm trong giỏ hàng
            $dataCart = array_map(fn($value) => $value['id'], $productCarts);
            Cart::destroy($dataCart);

            // Cam kết giao dịch
            DB::commit();

            // Thông báo thành công và chuyển hướng
            sweetalert("Đơn hàng đã được đặt!", NotificationInterface::SUCCESS, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return redirect()->route("order-success", ['id' => $order->id]);
        } catch (\Exception $e) {
            // Hủy giao dịch khi có lỗi
            DB::rollBack();

            // Ghi log lỗi hoặc thông báo lỗi (có thể sử dụng sweetalert để báo lỗi)
            sweetalert("Đã xảy ra lỗi khi đặt hàng!", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);

            // Quay lại trang trước với thông báo lỗi
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau!']);
        }
    }
}
