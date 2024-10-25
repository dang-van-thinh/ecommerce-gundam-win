@extends('client.pages.profile.layouts.master')
@section('title')
    Lịch sử mua hàng
@endsection
@section('profile')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="dashboard-right-box">
            <div class="order">
                <div class="sidebar-title">
                    <div class="loader-line"></div>
                    <h4>Lịch sử đơn hàng</h4>
                </div>
                <div class="row gy-4">
                    <div class="col-12">
                        <div class="order-box">
                            <div class="order-container">
                                <div class="order-icon"><i class="iconsax" data-icon="box"></i>
                                    <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                </div>
                                <div class="order-detail">
                                    <h5>Delivered</h5>
                                    <p>on Fri, 1 Mar</p>
                                </div>
                            </div>
                            <div class="product-order-detail">
                                <div class="product-box"> <a href="product.html"> <img
                                            src="/template/client/assets/images/notification/1.jpg" alt=""></a>
                                    <div class="order-wrap">
                                        <h5>Rustic Minidress with Halterneck</h5>
                                        <p>Versatile sporty slogans short sleeve quirky laid back
                                            orange lux hoodies vests pins badges.</p>
                                        <ul>
                                            <li>
                                                <p>Prize : </p><span>$20.00</span>
                                            </li>
                                            <li>
                                                <p>Size : </p><span>M</span>
                                            </li>
                                            <li>
                                                <p>Order Id :</p><span>ghat56han50</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="return-box">
                                <div class="review-box">
                                    <ul class="rating">
                                        <li> <i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i
                                                class="fa-solid fa-star"> </i><i class="fa-solid fa-star-half-stroke"></i><i
                                                class="fa-regular fa-star"></i></li>
                                    </ul><span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View"
                                        tabindex="0">Write Review</span>
                                </div>
                                <h6> <span> </span>* Exchange/Return window closed on 20 mar</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="order-box">
                            <div class="order-container">
                                <div class="order-icon"><i class="iconsax" data-icon="undo"></i>
                                    <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                </div>
                                <div class="order-detail">
                                    <h5>Refund Credited</h5>
                                    <p> Your Refund Of <b> $389.00 </b>For then return has been
                                        processed Successfully on 4th Apr.<a href="#"> View Refund
                                            details</a></p>
                                </div>
                            </div>
                            <div class="product-order-detail">
                                <div class="product-box"> <a href="product.html"> <img
                                            src="/template/client/assets/images/notification/9.jpg" alt=""></a>
                                    <div class="order-wrap">
                                        <h5>Rustic Minidress with Halterneck</h5>
                                        <p>Versatile sporty slogans short sleeve quirky laid back
                                            orange lux hoodies vests pins badges.</p>
                                        <ul>
                                            <li>
                                                <p>Prize : </p><span>$20.00</span>
                                            </li>
                                            <li>
                                                <p>Size : </p><span>M</span>
                                            </li>
                                            <li>
                                                <p>Order Id :</p><span>ghat56han50</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="return-box">
                                <div class="review-box">
                                    <ul class="rating">
                                        <li> <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                class="fa-regular fa-star"></i></li>
                                    </ul>
                                </div>
                                <h6> * Exchange/Return window closed on 20 mar</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="order-box">
                            <div class="order-container">
                                <div class="order-icon"><i class="iconsax" data-icon="box"></i>
                                    <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                </div>
                                <div class="order-detail">
                                    <h5>Delivered</h5>
                                    <p>on Fri, 1 Mar</p>
                                </div>
                            </div>
                            <div class="product-order-detail">
                                <div class="product-box"> <a href="product.html"> <img
                                            src="/template/client/assets/images/notification/2.jpg" alt=""></a>
                                    <div class="order-wrap">
                                        <h5>Rustic Minidress with Halterneck</h5>
                                        <p>Versatile sporty slogans short sleeve quirky laid back
                                            orange lux hoodies vests pins badges.</p>
                                        <ul>
                                            <li>
                                                <p>Prize : </p><span>$20.00</span>
                                            </li>
                                            <li>
                                                <p>Size : </p><span>M</span>
                                            </li>
                                            <li>
                                                <p>Order Id :</p><span>ghat56han50</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="return-box">
                                <div class="review-box">
                                    <ul class="rating">
                                        <li> <i class="fa-solid fa-star"> </i><i class="fa-solid fa-star"> </i><i
                                                class="fa-solid fa-star"> </i><i class="fa-solid fa-star-half-stroke"></i><i
                                                class="fa-regular fa-star"></i></li>
                                    </ul><span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View"
                                        tabindex="0">Write Review</span>
                                </div>
                                <h6> * Exchange/Return window closed on 20 mar</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="order-box">
                            <div class="order-container">
                                <div class="order-icon"><i class="iconsax" data-icon="box-add"></i>
                                    <div class="couplet"><i class="fa-solid fa-xmark"></i></div>
                                </div>
                                <div class="order-detail">
                                    <h5>Cancelled</h5>
                                    <p>on Fri, 1 Mar</p>
                                    <h6> <b>Refund lanitiated : </b>$774.00 on Thu, 24 Feb 2024. <a href="#"> View
                                            Refunddetails</a></h6>
                                </div>
                            </div>
                            <div class="product-order-detail">
                                <div class="product-box"> <a href="product.html"> <img
                                            src="/template/client/assets/images/notification/6.jpg" alt=""></a>
                                    <div class="order-wrap">
                                        <h5>Rustic Minidress with Halterneck</h5>
                                        <p>Versatile sporty slogans short sleeve quirky laid back
                                            orange lux hoodies vests pins badges.</p>
                                        <ul>
                                            <li>
                                                <p>Prize : </p><span>$20.00</span>
                                            </li>
                                            <li>
                                                <p>Size : </p><span>M</span>
                                            </li>
                                            <li>
                                                <p>Order Id :</p><span>ghat56han50</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="return-box">
                                <div class="review-box">
                                    <ul class="rating">
                                        <li> <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i
                                                class="fa-regular fa-star"></i></li>
                                    </ul>
                                </div>
                                <h6> * Exchange/Return window closed on 20 mar</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
