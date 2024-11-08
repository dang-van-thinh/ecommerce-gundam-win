<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

use function PHPUnit\Framework\throwException;

class ProductController extends Controller
{
    public function addToCart(Request $request)
    {
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
    }

    public function deleteToCart(Request $request)
    {
        $variantId = $request->input('variantId');
        $userId = $request->input('userId');
        if (Cart::query()->findOrFail($variantId)->delete()) {
            $numberCart = Cart::where('user_id', $userId)->count('*');
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
            ]);
        }
        return response()->json([
            'message' => "Xóa thành công"
        ], 400);
    }

    public function updateToCart(Request $request)
    {
        $variantId =  $request->input('idVariant');
        $newQuantity = $request->input('quantity');

        $cartOfUser = Cart::with('productVariant')->where('id', $variantId)->first();
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
    }


    public function productBuyNow(Request $request)
    {
        $userId = $request->input('userId');
        $quantity = $request->input('quantity');
        $variantId = $request->input('variantId');

        // tim kiem bien the
        $productVariant = ProductVariant::where('id', $variantId)->first()->toArray();
        // dd($productVariant->toArray());

        if ($productVariant) {
            return response()->json([
                'productCheckout' => $productVariant,
                'url' => route('check-out-now')
            ]);
        }
        return response()->json([
            'message' => "Không tìm thấy sản phẩm phù hợp"
        ], 400);
    }

    public function getPrductVariant(Request $request)
    {
        // dd($request->query('userId'));
        $userId = $request->query('userId');
        $quantity = $request->query('quantity');
        $variantId = $request->query('variantId');
        $productResponse = ProductVariant::with(['product', 'attributeValues.attribute'])->where('id', $variantId)->first();
        return response()->json([
            'productResponse' => $productResponse,
            'quantity' => $quantity
        ]);
    }
}
