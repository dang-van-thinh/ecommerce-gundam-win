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
                                <div class="col-xxl-4"><label for="address-billing-0"> <span class="delivery-address-box">
                                            <span class="form-check"> <input class="custom-radio" id="address-billing-0"
                                                    type="radio" checked="checked" name="radio"></span><span
                                                class="address-detail"><span class="address"> <span
                                                        class="address-title">New Home </span></span><span class="address">
                                                    <span class="address-home"> <span class="address-tag">
                                                            Address:</span>26, Starts Hollow
                                                        Colony, Denver, Colorado, United States</span></span><span
                                                    class="address"> <span class="address-home"> <span
                                                            class="address-tag">Pin Code:</span>80014</span></span><span
                                                    class="address"> <span class="address-home"> <span
                                                            class="address-tag">Phone :</span>+1
                                                        5551855359</span></span></span></span></label></div>
                                <div class="col-xxl-4"><label for="address-billing-1"> <span class="delivery-address-box">
                                            <span class="form-check"> <input class="custom-radio" id="address-billing-1"
                                                    type="radio" name="radio"></span><span class="address-detail"><span
                                                    class="address"> <span class="address-title">Old Home
                                                    </span></span><span class="address"> <span class="address-home">
                                                        <span class="address-tag"> Address:</span>53B, Claire New
                                                        Street, San Jose, California, United States</span></span><span
                                                    class="address"> <span class="address-home"> <span
                                                            class="address-tag">Pin Code:</span>94088</span></span><span
                                                    class="address"> <span class="address-home"> <span
                                                            class="address-tag">Phone :</span>+1
                                                        5551855359</span></span></span></span></label></div>
                                <div class="col-xxl-4"><label for="address-billing-2"> <span class="delivery-address-box">
                                            <span class="form-check"> <input class="custom-radio" id="address-billing-2"
                                                    type="radio" name="radio"></span><span class="address-detail"><span
                                                    class="address"> <span class="address-title">IT
                                                        Office</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">
                                                            Address:</span>101 Maple Drive, Placeholder Town, USA
                                                        44556</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Pin
                                                            Code:</span>54786</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Phone :</span>+1
                                                        2547896314</span></span></span></span></label></div>
                            </div>
                        </div>
                        <div class="address-option">
                            <div class="address-title">
                                <h4>Billing Address</h4><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#address-modal" title="add product" tabindex="0">+ Add New
                                    Address</a>
                            </div>
                            <div class="row">
                                <div class="col-xxl-4"><label for="address-billing-3"> <span class="delivery-address-box">
                                            <span class="form-check"> <input class="custom-radio" id="address-billing-3"
                                                    type="radio" name="radio"></span><span class="address-detail"><span
                                                    class="address"> <span class="address-title">New Home
                                                    </span></span><span class="address"> <span class="address-home">
                                                        <span class="address-tag"> Address:</span>123 Main Street,
                                                        Anytown, Colorado, United States</span></span><span class="address">
                                                    <span class="address-home"> <span class="address-tag">Pin
                                                            Code:</span>85421</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Phone :</span>+1
                                                        7845123658</span></span></span></span></label></div>
                                <div class="col-xxl-4"><label for="address-billing-4"> <span
                                            class="delivery-address-box"> <span class="form-check"> <input
                                                    class="custom-radio" id="address-billing-4" type="radio"
                                                    checked="checked" name="radio"></span><span
                                                class="address-detail"><span class="address"> <span
                                                        class="address-title">Old Home </span></span><span
                                                    class="address"> <span class="address-home"> <span
                                                            class="address-tag"> Address:</span>456 Elm Street, Sample
                                                        City, United States</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Pin
                                                            Code:</span>35412</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Phone :</span>+1
                                                        9547862134</span></span></span></span></label></div>
                                <div class="col-xxl-4"><label for="address-billing-6"> <span
                                            class="delivery-address-box"> <span class="form-check"> <input
                                                    class="custom-radio" id="address-billing-6" type="radio"
                                                    name="radio"></span><span class="address-detail"><span
                                                    class="address"> <span class="address-title">IT
                                                        Office</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">
                                                            Address:</span>101 Maple Drive, Placeholder Town, United
                                                        States</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Pin
                                                            Code:</span>57412</span></span><span class="address"> <span
                                                        class="address-home"> <span class="address-tag">Phone :</span>+1
                                                        87453312145</span></span></span></span></label></div>
                            </div>
                        </div>
                        <div class="payment-options">
                            <h4 class="mb-3">Billing Address</h4>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <div class="payment-box"><input class="custom-radio me-2" id="cod"
                                            type="radio" checked="checked" name="radio"><label
                                            for="cod">Cod</label></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"><input class="custom-radio me-2" id="stripe"
                                            type="radio" name="radio"><label for="stripe">Stripe</label></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"><input class="custom-radio me-2" id="paypal"
                                            type="radio" name="radio"><label for="paypal">Paypal</label></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"><input class="custom-radio me-2" id="mollie"
                                            type="radio" name="radio"><label for="mollie">Mollie</label></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"><input class="custom-radio me-2" id="razor-pay"
                                            type="radio" name="radio"><label for="razor-pay">Razor Pay</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4">
                    <div class="right-sidebar-checkout">
                        <h4>Checkout</h4>
                        <div class="cart-listing">
                            <ul>
                                <li> <img src="../assets/images/other-img/7.jpg" alt="">
                                    <div>
                                        <h6>Printed Long-sleeve Dress</h6><span>Green</span>
                                    </div>
                                    <p>$50.00</p>
                                </li>
                                <li> <img src="../assets/images/other-img/6.jpg" alt="">
                                    <div>
                                        <h6>Teddy Bear Coats</h6><span>Black </span>
                                    </div>
                                    <p>$40.00</p>
                                </li>
                                <li> <img src="../assets/images/other-img/5.jpg" alt="">
                                    <div>
                                        <h6>Colorful wind Coats</h6><span>white</span>
                                    </div>
                                    <p>$80.00</p>
                                </li>
                            </ul>
                            <div class="summary-total">
                                <ul>
                                    <li>
                                        <p>Subtotal</p><span>$220.00 </span>
                                    </li>
                                    <li>
                                        <p>Shipping</p><span>Enter shipping address</span>
                                    </li>
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
                                <div class="coupon-code"> <input type="text" placeholder="Enter Coupon Code"><button
                                        class="btn">Apply</button></div>
                            </div>
                            <div class="total">
                                <h6>Total : </h6>
                                <h6>$ 37.73</h6>
                            </div>
                            <div class="order-button"><a class="btn btn_black sm w-100 rounded" href="#">Place
                                    Order
                                </a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
