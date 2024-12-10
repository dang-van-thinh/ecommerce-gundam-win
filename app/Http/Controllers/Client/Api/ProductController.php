<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use PhpParser\Builder\Class_;

use function PHPUnit\Framework\throwException;

class ProductController extends Controller
{
    // input : {
    //    "userId":2,
    //    "quantity":2,
    //    "variantId":3
    //}
    public function addToCart(Request $request)
    {
        try {
            $rules = [
                'userId' => 'required|integer|exists:users,id',
                'quantity' => 'required|integer|min:1',
                'variantId' => 'required|integer'
            ];
            $messages = [
                'userId.required' => 'Id không được để trống !',
                'userId.integer' => 'Id không đúng định dạng !',
                'userId.exists' => 'Người dùng không tồn tại trong hệ thống!',
                'quantity.required' => 'Số lượng không được để trống!',
                'quantity.integer' => 'Số lượng phải là số nguyên hợp lệ!',
                'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1!',
                'variantId.required' => 'Id biến thể sản phẩm không được để trống!',
                'variantId.integer' => 'Id biến thể sản phẩm phải là số nguyên hợp lệ!'
            ];

            $request->validate($rules, $messages);


            $userId = $request->input('userId');
            $quantity = $request->input('quantity');
            $variantId = $request->input('variantId');

            // tao moi data them moi
            $cart = [
                'user_id' => $userId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity
            ];

            // check trung
            $carted = Cart::with('productVariant')->where('user_id', $userId)->where([
                ['user_id', '=', $userId],
                ['product_variant_id', '=', $variantId]
            ])->first();
            // dd($carted->toArray());


            if ($carted) {
                $quantityNew = $carted->quantity + $quantity;
                if ($quantityNew >  $carted->toArray()['product_variant']['quantity']) {
                    return response()->json([
                        'message' => "Số lượng sản phẩm trong giỏ hàng lớn hơn số sản phẩm tồn kho !"
                    ], 400);
                }
                // dd($quantity);
                $carted->update([
                    'quantity' => $quantityNew
                ]);
            } else {
                Cart::query()->create($cart);
            }

            $cartResponse = Cart::where('user_id', $userId)->count('*');
            return response()->json([
                'message' => [
                    'numberCart' => $cartResponse
                ]
            ]);
        } catch (\Exception $th) {
            if ($th instanceof ValidationException) {
                return response()->json([
                    'message' => $th->errors()
                ], status: 400);
            }

            return response()->json([
                'message' => $th
            ], status: 500);
        }
    }

    //input = {
    //"userId":,
    //"cartId":
    //}
    public function deleteToCart(Request $request)
    {
        try {
            $rules = [
                'userId' => 'required|integer|exists:users,id',
                'cartId' => 'required|integer',
            ];
            $messages = [
                'userId.required' => 'Id người dùng không được để trống!',
                'userId.integer' => 'Id người dùng phải là số nguyên hợp lệ!',
                'userId.exists' => 'Id người dùng không tồn tại trong hệ thống!',
                'cartId.required' => 'Id giỏ hàng không được để trống!',
                'cartId.integer' => 'Id giỏ hàng phải là số nguyên hợp lệ!',
            ];

            $request->validate($rules, $messages);


            $cartId = $request->input('cartId'); // nay la id cart
            $userId = $request->input('userId');
            if (Cart::query()->findOrFail($cartId)->delete()) {
                $numberCart = Cart::where('user_id', $userId)->count('*'); // dem lai so luong product trong cart
                // lay lai du lieu cart de tra ra
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
                return response()->json([
                    'message' => [
                        'status' => "Xóa thành công",
                        'numberCart' => $numberCart,
                        'productCart' => $productResponse
                    ]
                ], 200);
            }
            return response()->json([
                'message' => "Xóa thành công"
            ], 400);
        } catch (\Throwable $th) {
            if ($th instanceof ValidationException) {
                return response()->json([
                    'message' => $th->errors()
                ], status: 400);
            }
            Log::error($th->getMessage());
            return response()->json([
                "message" => $th->getMessage()
            ], 404);
        }
    }

    // input : {
    //    "userId":2,
    //    "cartId":132,
    //    "quantity": 2
    //}
    public function updateToCart(Request $request)
    {
        try {
            $rules = [
                'userId' => 'required|integer|exists:users,id',
                'cartId' => 'required|integer|exists:carts,id',
                'quantity' => 'required|integer|min:1',
            ];

            $messages = [
                'userId.required' => 'Id người dùng không được để trống!',
                'userId.integer' => 'Id người dùng phải là số nguyên hợp lệ!',
                'userId.exists' => 'Id người dùng không tồn tại trong hệ thống!',

                'cartId.required' => 'Id giỏ hàng không được để trống!',
                'cartId.integer' => 'Id giỏ hàng phải là số nguyên hợp lệ!',
                'cartId.exists' => 'Id giỏ hàng không tồn tại trong hệ thống!',

                'quantity.required' => 'Số lượng không được để trống!',
                'quantity.integer' => 'Số lượng phải là số nguyên hợp lệ!',
                'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1!',
            ];
            $request->validate($rules, $messages);


            $cartId =  $request->input('cartId');
          
            $newQuantity = $request->input('quantity');

            $cartOfUser = Cart::with('productVariant')->where('id', $cartId)->first();
            // dd($cartOfUser->toArray());
            if ($newQuantity < 0 || $newQuantity > $cartOfUser->toArray()['product_variant']['quantity']) {
                return response()->json([
                    'message' => 'Số lượng không phù hợp !'
                ], 400);
            } else {
                $cartOfUser->update(['quantity' => $newQuantity]);
            }
            return response()->json([
                'message' => 'Thay đổi số lượng thành công'
            ]);
        } catch (\Throwable $exception) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => $exception->errors()
                ], status: 400);
            }
            Log::error($exception->getMessage());
            return response()->json([
                "message" => $exception->getMessage()
            ], 404);
        }
    }

    // input: {
    //    "userId":2,
    //    "quantity":2,
    //    "variantId":99
    //}
    public function productBuyNow(Request $request)
    {
        try {
            // Thực hiện validate trực tiếp
            $validated = $request->validate([
                'userId' => 'required|integer|exists:users,id',
                'quantity' => 'required|integer|min:1',
                'variantId' => 'required|integer|exists:product_variants,id',
            ], [
                'userId.required' => 'Người dùng là bắt buộc.',
                'userId.integer' => 'ID người dùng phải là một số.',
                'userId.exists' => 'Người dùng không tồn tại.',
                'quantity.required' => 'Số lượng là bắt buộc.',
                'quantity.integer' => 'Số lượng phải là một số nguyên.',
                'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
                'variantId.required' => 'Mã biến thể sản phẩm là bắt buộc.',
                'variantId.integer' => 'Mã biến thể phải là một số.',
                'variantId.exists' => 'Biến thể sản phẩm không tồn tại.',
            ]);

            // Tìm kiếm biến thể sản phẩm
            $productVariant = ProductVariant::find($validated['variantId']);

            if (!$productVariant) {
                return response()->json([
                    'message' => 'Không tìm thấy bản ghi phù hợp!',
                ], 404);
            }

            // Trả về kết quả
            return response()->json([
                'productCheckout' => $productVariant,
                'quantity' => $validated['quantity'],
                'url' => route('check-out-now'),
            ]);
        } catch (\Exception $exception) {
            // Ghi log lỗi
            Log::error('Lỗi trong quá trình xử lý Buy Now: ' . $exception->getMessage());

            // Trả về lỗi chi tiết
            return response()->json([
                'error' => $exception->errors(),
            ], 500);
        }
    }

    // input : {
    //    "userId":2,
    //    "quantity":2,
    //    "variantId":99
    //}
    public function getPrductVariant(Request $request)
    {
        try {
            // Thực hiện validate dữ liệu đầu vào
            $validated = $request->validate([
                'userId' => 'required|integer|exists:users,id',
                'quantity' => 'required|integer|min:1',
                'variantId' => 'required|integer|exists:product_variants,id',
            ], [
                'userId.required' => 'Người dùng là bắt buộc.',
                'userId.integer' => 'ID người dùng phải là một số nguyên.',
                'userId.exists' => 'Người dùng không tồn tại.',
                'quantity.required' => 'Số lượng là bắt buộc.',
                'quantity.integer' => 'Số lượng phải là một số nguyên.',
                'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
                'variantId.required' => 'Biến thể sản phẩm là bắt buộc.',
                'variantId.integer' => 'Mã biến thể phải là một số nguyên.',
                'variantId.exists' => 'Biến thể sản phẩm không tồn tại.',
            ]);

            // Nhận dữ liệu đã validate
            $userId = $validated['userId'];
            $quantity = $validated['quantity'];
            $variantId = $validated['variantId'];

            // Lấy thông tin biến thể sản phẩm
            $productResponse = ProductVariant::with(['product', 'attributeValues.attribute'])->findOrFail($variantId);

            // Tính tổng giá trị đơn hàng
            $totalOrder = $productResponse->price * $quantity;

            // Lấy danh sách voucher hợp lệ
            $vouchers = VoucherUsage::join('vouchers as v', 'voucher_usages.voucher_id', '=', 'v.id')
                ->where([
                    ['v.status', '=', 'ACTIVE'],
                    ['user_id', '=', $userId],
                    ['v.start_date', '<=', now()],
                    ['v.end_date', '>=', now()],
                    ['v.limit', '>', 0],
                ])
                ->where(function ($query) {
                    $query->whereNull('v.limited_uses')
                        ->orWhereColumn('voucher_usages.used', '<=', 'v.limited_uses');
                })
                ->orderBy('voucher_usages.id', 'desc')
                ->get();

            // Tìm voucher áp dụng tốt nhất
            $voucherApply = null;
            $discountMax = 0;

            foreach ($vouchers as $voucher) {
                if (
                    $totalOrder >= $voucher->min_order_value &&
                    $totalOrder <= $voucher->max_order_value
                ) {
                    $discount = $this->calcuDiscountVoucher($voucher, $totalOrder);

                    if ($discount > $discountMax) {
                        $discountMax = $discount;
                        $voucherApply = $voucher;
                    }
                }
            }

            // Trả về JSON response
            return response()->json([
                'productResponse' => $productResponse,
                'quantity' => $quantity,
                'vouchers' => $vouchers,
                'voucherApply' => $voucherApply,
            ]);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'message'  => $exception->errors(),
            ], 500);
        }
    }


    public function calcuDiscountVoucher($voucher, $totalOrder)
    { // tinh ra gia tri voucher giam duoc
        if ($voucher->discount_type == 'PERCENTAGE') {
            return $totalOrder * ($voucher->discount_value / 100);
        } else {
            return $voucher->discount_value;
        }
    }
}
