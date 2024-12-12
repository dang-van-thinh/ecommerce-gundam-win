<?php

namespace App\Http\Controllers\Client;

use App\Events\OrderToAdminEvent;
use App\Events\OrderToAdminNotification;
use App\Exceptions\NotFoundException;
use App\Exceptions\Order\PaymentException;
use App\Exceptions\Order\PlaceOrderException;
use App\Http\Controllers\Client\Api\ProductController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\placeOrder\CreateOrderBuyNow;
use App\Http\Requests\Client\placeOrder\CreatePlaceOrderRequest;
use App\Models\AddressUser;
use App\Models\Cart;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Exception;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class CheckOutController extends Controller
{
    public $productControllerApi;
    public function __construct(ProductController $productControllerApi)
    {
        $this->productControllerApi = $productControllerApi;
    }
    public function checkOutByCart()
    {
        try {
            $userId = Auth::id();
            $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get();
            // dd($productCarts);

            // khac thanh toan onlien thi thuc hien tru luon san pham trong kho
            foreach ($productCarts as $key => $item) {
                // dd($item->toArray());
                if ($item->productVariant->product->status === 'IN_ACTIVE') {
                    throw new PlaceOrderException('Tồn tại sản phẩm đã ngừng bán và không thể đặt hàng. Vui lòng kiểm tra lại');
                }

                if ($item->productVariant->quantity > 0 && $item->quantity <= $item->productVariant->quantity) {
                } else {
                    throw new PlaceOrderException('Số lượng sản phẩm mua không phù hợp với sản phẩm trong kho, vui lòng kiểm tra lại !');
                }
            }
            $productCarts = $productCarts->toArray();

            $productResponse = [];
            foreach ($productCarts as $key => $value) {
                $productResponse[$key] = [];
                foreach ($productCarts as $key => $productCart) {
                    $productResponse[$key]['cart'] = $productCart;
                    $productResponse[$key]['product_variant'] = $productCart['product_variant'];
                    $productResponse[$key]['product'] = $productCart['product_variant']['product'];
                }
            }
            // dd($productResponse, $productCarts);
            $totalOrder = 0;

            foreach ($productCarts as $key => $product) {
                $totalOrder += $product['quantity'] * $product['product_variant']['price'];
            }

            $vouchers = VoucherUsage::join("vouchers as v", 'voucher_usages.voucher_id', '=', 'v.id')
                ->where([
                    ['v.status', '=', 'ACTIVE'],
                    ['user_id', $userId],
                    ['v.start_date', '<=', now()],
                    ['v.end_date', '>=', now()],
                    ['v.limit', '>', 0]
                ])
                ->where(function ($query) {
                    $query->whereNull('v.limited_uses')
                        ->orWhereColumn('voucher_usages.used', '<=', 'v.limited_uses');
                })
                ->orderBy('voucher_usages.id', 'desc')
                ->select([
                    'voucher_usages.id as id',
                    'voucher_usages.user_id',
                    'voucher_usages.voucher_id',
                    'voucher_usages.used',
                    'v.id as voucher_id', // Alias cho `vouchers.id`
                    'v.code',
                    'v.description',
                    'v.limit',
                    'v.name',
                    'v.discount_type',
                    'v.discount_value',
                    'v.min_order_value',
                    'v.max_order_value',
                    'v.status',
                    'v.voucher_used',
                    'v.start_date',
                    'v.end_date',
                    'v.type',
                    'v.limited_uses'
                ])
                ->get();

            $voucherApply = null;
            $discountMax = 0;
            // dd($vouchers->toArray());
            foreach ($vouchers as $key => $voucher) { // kiem tra gia tri don hang hop le voi voucher
                $limitUse = $voucher->limited_uses;
                $used = $voucher->used;
                // dd($voucher,$limitUse,$used);
                if ($totalOrder >= $voucher->min_order_value && $totalOrder <= $voucher->max_order_value && ($used != $limitUse || $limitUse == null)) { // hop le ve gia va so lan su dung
                    $discount = $this->productControllerApi->calcuDiscountVoucher($voucher, $totalOrder);
                    // dd($discount);
                    // so sanh de lay voucher co gia tri giam cao nhat cao nhat
                    if ($discount > $discountMax) {
                        $discountMax = $discount;
                        $voucherApply = $voucher;
                    }
                }
            }

            // dd($voucherApply->toArray());
            $userAddress = AddressUser::where('user_id', $userId)->get();
            $provinces = Province::all();
            $voucher = VoucherUsage::with('voucher')
                ->where('user_id', $userId)
                ->latest('id') // Sắp xếp theo id giảm dần
                ->get();
// dd($voucher->toArray());
            return view('client.pages.check-out.index', [
                'productResponse' => $productResponse,
                'userAddress' => $userAddress,
                'provinces' => $provinces,
                'voucher' => $voucher,
                'voucherApply' => $voucherApply
            ]);
        } catch (\Throwable $th) {
            if ($th instanceof PlaceOrderException) {
                sweetalert($th->getMessage(), NotificationInterface::ERROR, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false
                ]);
            }
            return back();
        }
    }

    public function checkOutByNow()
    {

        $userId = Auth::id();
        $userAddress = AddressUser::where('user_id', $userId)->get();
        $provinces = Province::all();
        return view('client.pages.check-out.check-out-buy-now', [
            'userAddress' => $userAddress,
            'provinces' => $provinces
        ]);
    }

    public function placeOrder(CreatePlaceOrderRequest $request)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $userId = Auth::id();
            $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])
                ->where('user_id', $userId)
                ->get();
            // dd($productCarts->toArray());
            if ($productCarts->isEmpty()) {
                throw new NotFoundException('Không có sản phẩm nào được chọn!');
            }

            $paymentMethod = $request->payment_method === 'momo' || $request->payment_method === 'vnpay' ? "BANK_TRANSFER" : "CASH";

            $addressUser = AddressUser::with(['province', 'district', 'ward'])->where('id', $request->address_user_id)->first()->toArray();
            $fullAddress = $addressUser['address_detail'] . " - " . $addressUser['ward']['name']
                . " - " . $addressUser['district']['name'] . " - " . $addressUser['province']['name'];

            $dataOrder = [
                "user_id" => $userId,
                "total_amount" => $request->total_amount,
                "payment_method" => $paymentMethod,
                "note" => $request->note,
                "confirm_status" => "IN_ACTIVE",
                "status" => "PENDING",
                "phone" => $addressUser['phone'],
                "customer_name" =>  $addressUser['name'],
                "full_address" =>  $fullAddress,
                "code" => $this->codeOrder(),
                "discount_amount" => $request->discount_amount,
                "voucher" => $request->voucher_id,
                "voucherUsage" => $request->id_voucherUsage,
            ];
// dd($dataOrder);
            if ($paymentMethod === "BANK_TRANSFER") {
                // dd($dataOrder);
                if ($dataOrder['total_amount'] < 0) {
                    throw new PlaceOrderException('Thanh toán online không hỗ trợ thanh toán cho đơn nhỏ hơn 0 VND');
                }

                $urlRedirect = route('confirmCheckout');
                $paymentUrl = $this->payMomo($dataOrder, $urlRedirect);

                if (!$paymentUrl) {
                    throw new Exception("Không thể tạo yêu cầu thanh toán!");
                }
                DB::commit();
                return redirect()->to($paymentUrl);
            }

            // Thanh toán bằng tiền mặt
            $order = $this->createOrder($productCarts, null, $dataOrder);

            DB::commit();

            $this->sendNotificationToAdmin($order);

            sweetalert("Đơn hàng đã được đặt!", NotificationInterface::SUCCESS, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);

            return redirect()->route("order-success", ['id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->handlePlaceOrderException($e);
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau!']);
        }
    }

    public function placeOrderBuyNow(CreateOrderBuyNow $request)
    { {
            try {
                // dd($request->all());
                DB::beginTransaction();
                $userId = Auth::id();
                $variantId = $request->variant;
                $productVariant = ProductVariant::with('product')->where('id', $variantId)->first();
                // dd($productVariant->toArray());

                $paymentMethod = $request->payment_method === 'momo' || $request->payment_method === 'vnpay' ? "BANK_TRANSFER" : "CASH";

                $addressUser = AddressUser::with(['province', 'district', 'ward'])->where('id', $request->address_user_id)->first()->toArray();
                $fullAddress = $addressUser['address_detail'] . " - " . $addressUser['ward']['name']
                    . " - " . $addressUser['district']['name'] . " - " . $addressUser['province']['name'];

                $dataOrder = [
                    "user_id" => $userId,
                    "total_amount" => $request->total_amount,
                    "payment_method" => $paymentMethod,
                    "note" => $request->note,
                    "confirm_status" => "IN_ACTIVE",
                    "status" => "PENDING",
                    "phone" => $addressUser['phone'],
                    "customer_name" =>  $addressUser['name'],
                    "full_address" =>  $fullAddress,
                    "code" => $this->codeOrder(),
                    "discount_amount" => $request->discount_amount,
                    "voucher" => $request->voucher_id,
                    "voucherUsage" => $request->id_voucherUsage,
                    "productVariant" => $variantId,
                    "quantityBuy" => $request->quantity
                ];
                // dd($dataOrder);

                if ($paymentMethod === "BANK_TRANSFER") {
                    // dd($dataOrder);
                    if ($dataOrder['total_amount'] < 0) {
                        throw new PlaceOrderException('Thanh toán online không hỗ trợ thanh toán cho đơn nhỏ hơn 0 VND');
                    }

                    $urlRedirect = route('confirmCheckout');
                    $paymentUrl = $this->payMomo($dataOrder, $urlRedirect);

                    if (!$paymentUrl) {
                        throw new Exception("Không thể tạo yêu cầu thanh toán!");
                    }
                    DB::commit();
                    return redirect()->to($paymentUrl);
                }

                // Thanh toán bằng tiền mặt
                $order = $this->createOrder(null, $productVariant, $dataOrder);

                DB::commit();

                $this->sendNotificationToAdmin($order);

                sweetalert("Đơn hàng đã được đặt!", NotificationInterface::SUCCESS, [
                    'position' => "center",
                    'timeOut' => '',
                    'closeButton' => false
                ]);

                return redirect()->route("order-success", ['id' => $order->id]);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->handlePlaceOrderException($e);
                return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau!']);
            }
        }
    }
    public function confirmCheckout(Request $request)
    {
        // dd($request->all());
        // Lấy tất cả dữ liệu từ URL
        $requestData = $request->all();
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
                '&extraData=' . $requestData['extraData'] .
                "&message=" . $requestData['message'];
            // dd($rawHash);
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
                $dataExtract = json_decode($requestData['extraData'], true);

                // dd($dataExtract);
                $dataOrder = [
                    "user_id" => $dataExtract['user_id'],
                    "total_amount" => $dataExtract['total_amount'],
                    "payment_method" => $dataExtract['payment_method'],
                    "note" => $dataExtract['note'],
                    "confirm_status" => $dataExtract['confirm_status'],
                    "status" => $dataExtract['status'],
                    "phone" => $dataExtract['phone'],
                    "customer_name" =>  $dataExtract['customer_name'],
                    "full_address" =>  $dataExtract['full_address'],
                    "code" => $dataExtract['code'],
                    "discount_amount" => $dataExtract['discount_amount'],
                    "payment_status" => "PAID",
                    "voucher" => $dataExtract['voucher'],
                    "voucherUsage" => $dataExtract['voucherUsage'],
                ];
                if (!isset($dataExtract['productVariant']) ) { // neu nhu khong phai don mua ngay thi...
                    $userId = $dataExtract['user_id'];
                    $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])
                        ->where('user_id', $userId)
                        ->get();
                    $order = $this->createOrder($productCarts, null, $dataOrder);
                } else {
                    $variantId = $dataExtract['productVariant'];

                    $dataOrder['productVariant'] = $variantId;
                    $dataOrder['quantityBuy'] = $dataExtract['quantityBuy'];
                    $productVariant = ProductVariant::with('product')->where('id', $variantId)->first();
                    $order = $this->createOrder(null, $productVariant, $dataOrder);
                }

                $this->sendNotificationToAdmin($order);
                return redirect()->route('order-success', $order->id);
            }
            sweetalert("Tạo đơn hàng thât bại !", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return back(); // cho tro ve trang cu
        }
    }

    private function sendNotificationToAdmin($order)
    {
        // giao dichj thanh cong tien hanh them thong bao cho admin
        $notiMessage = "Đơn hàng #" . $order->code . " đã được tạo ";
        $notiData = [
            "title" => "Xác nhận đơn hàng mới ",
            "message" => $notiMessage,
            "redirect_url" => route("orders.edit", $order->id),
            "user_id" => 1 // mac dinh dang de la id admin , sau ma co nhieu hon 1 admin thi them sau
        ];
        $newNoti = Notification::create($notiData);
        broadcast(new OrderToAdminEvent($newNoti));
    }

    private function createOrder($productCarts = null, $productBuyNow = null, $dataOrder)
    {
        // dd($productCarts, $dataOrder);
        try {
            DB::beginTransaction();
            $order = Order::create($dataOrder);

            $orderItems = [];
            if ($productCarts != null) {
                foreach ($productCarts as $cart) {
                    $orderItems[] = [
                        'order_id' => $order->id,
                        'product_variant_id' => $cart->product_variant_id,
                        'product_name' => $cart->productVariant->product->name,
                        'product_price' => $cart->productVariant->price,
                        'quantity' => $cart->quantity,
                        'total_price' => $cart->quantity * $cart->productVariant->price,
                    ];
                }

                // thuc hien tru san pham trong kho
                foreach ($productCarts as $key => $item) {
                    if ($item->productVariant->quantity > 0 && $item->quantity <= $item->productVariant->quantity) {
                        $quantity = $item->productVariant->quantity - $item->quantity;
                        $sold = $item->productVariant->sold + $item->quantity;
                        // dd($item->productVariant->sold);
                        // Cập nhật lại số lượng trong bảng product_variants
                        $item->productVariant->quantity = $quantity; // cap nhat lai so luong ton kho
                        $item->productVariant->sold = $sold; // cap nhat so luong da ban
                        $item->productVariant->save();
                    } else {
                        throw new PlaceOrderException('Số lượng sản phẩm mua không phù hợp với sản phẩm trong kho !');
                    }
                }
                Cart::destroy($productCarts->pluck('id'));
            }

            if ($productBuyNow != null) {

                $productVariant = $productVariant = ProductVariant::with('product')->where('id', $dataOrder['productVariant'])->first();
                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $productVariant['id'],
                    'product_name' => $productVariant['product']['name'],
                    'product_price' => $productVariant['price'],
                    'quantity' => $dataOrder['quantityBuy'],
                    'total_price' => $dataOrder['quantityBuy'] * $productVariant['price']
                ];


                if ($productVariant->quantity > 0 && $dataOrder['quantityBuy'] <= $productVariant->quantity) {
                    $quantity = $productVariant->quantity - $dataOrder['quantityBuy'];
                    $sold = $productVariant->sold + $dataOrder['quantityBuy'];
                    // Cập nhật lại số lượng trong bảng product_variants

                    $productVariant->quantity = $quantity; // cap nhat lai so luong ton kho
                    $productVariant->sold = $sold; // cap nhat so luong da ban
                    $productVariant->save();
                } else {
                    throw new PlaceOrderException('Số lượng sản phẩm mua không phù hợp với sản phẩm trong kho !');
                }
            }

            OrderItem::insert($orderItems);
            if ($dataOrder['voucher'] && $dataOrder['voucherUsage']) {

                // dd($dataOrder['voucher'] , $dataOrder['voucherUsage']);
                $voucher = Voucher::find($dataOrder['voucher']);
                $voucherUsage = VoucherUsage::find( $dataOrder['voucherUsage'] );
                // dd($voucher->toArray() ,  $voucherUsage->toArray());
                if ($voucher && $voucherUsage) {
                    if ($voucher->limit > 0) {
                        // Giảm số lượng limit và tăng số lượng voucher_used
                        $voucher->update([
                            'limit' => $voucher->limit - 1,       // Giảm số lần có thể sử dụng
                            'voucher_used' => $voucher->voucher_used + 1, // Tăng số lần đã sử dụng
                        ]);
                    } else {
                        throw new PlaceOrderException("Voucher đã hết !");
                    }

                    $voucherUsage->update([
                        'used' => $voucherUsage->used + 1
                    ]);
                }
            }
            DB::commit();
            return $order;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function handlePlaceOrderException($e)
    {
        Log::debug('Loi cua dat hang' . $e->getMessage());
        if ($e instanceof PlaceOrderException) {

            sweetalert($e->getMessage(), NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
        } elseif ($e instanceof NotFoundException) {

            sweetalert($e->getMessage(), NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
        } else {
            sweetalert("Đã xảy ra lỗi khi đặt hàng!", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
        }
    }

    private function codeOrder()
    {
        // Tạo một chuỗi ngẫu nhiên gồm các chữ cái viết hoa và số với độ dài 14 ký tự
        // $code = Str::upper(Str::random(14));
        $time = now()->format('YmdHis');
        //        dd($time);

        // Đảm bảo chuỗi có cả số và chữ cái bằng cách trộn ký tự từ hai tập hợp riêng biệt
        $letters = Str::random(7); // Lấy 7 chữ cái ngẫu nhiên
        $numbers = substr(str_shuffle($time), 0, 7); // Lấy 4 số ngẫu nhiên

        // Gộp và xáo trộn chữ cái và số để đảm bảo vị trí ngẫu nhiên
        $mixedCode = str_shuffle($letters . $numbers);
        return strtoupper($mixedCode);
    }

    public function payMomo($dataOrder, $urlRedirect)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey = env("MOMO_ACCESS_KEY");
        $secretKey = env("MOMO_SECRET_KEY");
        $orderInfo = "Thanh toán MOMO"; // cai nay yeu cau khong duoc de trong
        $amount = $dataOrder['total_amount'];
        $orderId = $dataOrder['code'];
        $redirectUrl = $urlRedirect;
        $ipnUrl = $urlRedirect; // chuyen huong khi thanh cong
        $extraData = json_encode($dataOrder);
        $requestId = $dataOrder['code'];
        $requestType = "payWithATM";

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        // dd($result);
        if (!$result) {
            // Nếu không có kết quả, API có thể đã gặp lỗi kết nối
            dd("Error: No response from MoMo API.");
        }


        $jsonResult = json_decode($result, true);
        if (isset($jsonResult['errorCode']) && $jsonResult['errorCode'] != 0) {
            // Nếu có lỗi, hiển thị mã lỗi
            dd("MoMo API error: " . $jsonResult['errorCode'] . " - " . $jsonResult['localMessage']);
        }


        // $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        if (isset($jsonResult['payUrl'])) {
            return $jsonResult['payUrl'];
        } else {
            dd("Error: MoMo API did not return payUrl.", $jsonResult);
        }
        // header('Location: ' . $jsonResult['payUrl']);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}
