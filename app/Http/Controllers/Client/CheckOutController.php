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
            DB::transaction(function () use ($request, $productCarts) {
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
                $orderItem['order_id'] = $order->id;
                foreach ($productCarts as $key => $item) {

                    $orderItem['product_variant_id'] = $item['product_variant_id'];
                    $orderItem['product_name'] = $item['product_variant']['product']['name'];
                    $orderItem['product_price'] = $item['product_variant']['price'];
                    $orderItem['quantity'] = $item['quantity'];
                    $orderItem['total_price'] = $item['quantity'] * $item['product_variant']['price'];
                    $data[$key] = $orderItem;
                }
                // dd($order->toArray());
                OrderItem::insert($data);
                $dataCart = [];
                foreach ($productCarts as $key => $value) {
                    $dataCart[] = $value['id'];
                }
                Cart::destroy($dataCart);
            });

            sweetalert("Đơn hàng đã được đặt !", NotificationInterface::SUCCESS, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return redirect()->route("order-success");
        } catch (\Throwable $th) {
            sweetalert("Đặt hàng thất bại !", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return back();
        }
    }
}
