@extends('client.layouts.master')
@section('title')
    Thanh toán đơn hàng
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Thanh toán đơn hàng',
        'parent' => [
            'route' => '',
            'name' => 'Giỏ hàng',
        ],
    ]);
    <section class="section-b-space pt-0">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('place-order') }}" method="POST">
            @csrf
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xxl-9 col-lg-8">
                        <div class="left-sidebar-checkout sticky">
                            <div class="address-option">
                                <div class="address-title">
                                    <h4>Shipping Address </h4><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#address-modal" title="add product" tabindex="0">+ Add New
                                        Address</a>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-4">

                                        @foreach ($userAddress as $key => $item)
                                            {{-- @dd($item->toArray()) --}}
                                            <label for="address-billing-0">
                                                <span class="delivery-address-box">
                                                    <span class="form-check">
                                                        <input class="custom-radio" value="{{ $item['id'] }}"
                                                            data-value="{{ $key }}" id="address-billing-0"
                                                            type="radio"
                                                            @if ($item['default'] == 1) checked="checked" @endif
                                                            name="address_user_id">
                                                    </span>
                                                    <span class="address-detail">

                                                        <span class="address">
                                                            <span class="address-title"> New Home</span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag"> Address:</span>
                                                                {{ $item->address_detail }}
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Pin Code:</span>
                                                                80014
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Phone :</span>
                                                                +1 5551855359
                                                            </span>
                                                        </span>

                                                    </span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            <div class="payment-options">
                                <h4 class="mb-3">Billing Address</h4>
                                <div class="row gy-3">
                                    <div class="col-sm-6">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="cod" type="radio" checked="checked"
                                                value="CASH" name="payment_method">
                                            <label for="cod">Cod</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="stripe" type="radio"
                                                name="payment_method" value="BANK_TRANSFER">
                                            <label for="stripe">Online</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="address-option">
                                <textarea name="note" class="form-control" id="" placeholder="Ghi chú đơn hàng" cols="30"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4">
                        <div class="right-sidebar-checkout">
                            <h4>Checkout</h4>
                            <div class="cart-listing">
                                <ul>
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach ($productResponse as $key => $item)
                                        @php
                                            $totalAmount +=
                                                $item['product_variant']['price'] * $item['cart']['quantity'];
                                        @endphp
                                        <li>
                                            <img width="60px" src="{{ '/storage/' . $item['product']['image'] }}"
                                                alt="">
                                            <div>
                                                <h6>{{ $item['product']['name'] }}</h6>
                                                @foreach ($item['product_variant']['attribute_values'] as $variant)
                                                    <p>{{ $variant['attribute']['name'] }}: <span>
                                                            {{ $variant['name'] }} </span></p>
                                                @endforeach
                                            </div>
                                            <p>{{ number_format($item['product_variant']['price'] * $item['cart']['quantity'], 0, ',', '.') }}
                                                VND</p>
                                        </li>
                                    @endforeach


                                </ul>
                                <div class="summary-total">
                                    <ul>
                                        <li>
                                            <p>Subtotal</p>
                                            <span> {{ $totalAmount }}</span>

                                        </li>
                                        {{-- <li>
                                            <p>Shipping</p><span>Enter shipping address</span>
                                        </li> --}}
                                        <li>
                                            <p>Tax</p><span>$ 2.54</span>
                                        </li>
                                        <li>
                                            <p>Points</p><span>$ -10.00</span>
                                        </li>
                                        <li>
                                            <p>Wallet Balance</p><span>$ -84.40</span>
                                        </li>
                                    </ul>
                                    {{-- <div class="coupon-code">
                                        <input type="text" placeholder="Enter Coupon Code">
                                        <button class="btn">Apply</button>
                                    </div> --}}
                                </div>
                                <div class="total">
                                    <h6>Total : </h6>
                                    <h6>{{ number_format($totalAmount, 0, ',', '.') }} VND</h6>
                                    <input type="hidden" value="{{ $totalAmount }}" name="total_amount">
                                </div>
                                <div class="order-button">
                                    <button type="submit" class="btn btn_black sm w-100 rounded">Đặt hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
