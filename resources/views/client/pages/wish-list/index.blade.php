@extends('client.layouts.master')
@section('title')
    Sản phẩm yêu thích
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Sản phẩm yêu thích',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ]);
    <section class="section-b-space pt-0">
        <div class="custom-container wishlist-box container">
            <div class="product-tab-content ratio1_3">
                <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                    <div class="col">
                        <div class="product-box-3 product-wishlist">
                            <div class="img-wrapper">
                                <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                        href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i class="iconsax"
                                            data-icon="trash" aria-hidden="true"></i></a></div>
                                <div class="product-image"><a class="pro-first" href="#"> <img class="bg-img"
                                            src="/template/client/assets/images/product/product-3/1.jpg"
                                            alt="product"></a><a class="pro-sec" href="#"> <img class="bg-img"
                                            src="/template/client/assets/images/product/product-3/20.jpg"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i class="iconsax"
                                            data-icon="basket-2" aria-hidden="true"> </i></a><a href="compare.html"
                                        title="Compare" tabindex="0"><i class="iconsax" data-icon="arrow-up-down"
                                            aria-hidden="true"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" title="Quick View" tabindex="0"><i class="iconsax"
                                            data-icon="eye" aria-hidden="true"></i></a></div>
                                <div class="countdown">
                                    <ul class="clockdiv1">
                                        <li>
                                            <div class="timer">
                                                <div class="days"></div>
                                            </div><span class="title">Days</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="hours"></div>
                                            </div><span class="title">Hours</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="minutes"></div>
                                            </div><span class="title">Min</span>
                                        </li>
                                        <li class="dot"> <span>:</span></li>
                                        <li>
                                            <div class="timer">
                                                <div class="seconds"></div>
                                            </div><span class="title">Sec</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product-detail">
                                <ul class="rating">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                    <li><i class="fa-regular fa-star"></i></li>
                                    <li>4.3</li>
                                </ul><a href="#">
                                    <h6>Greciilooks Women's Stylish Top</h6>
                                </a>
                                <p class="list-per">Fashion is to please your eye. Shapes and proportions are for your
                                    intellect. It is important to be chic. Vanity is the healthiest thing in life.
                                    Elegance isn't solely defined by what you wear. It's how you carry yourself, how you
                                    speak, what you read. Fashion is made to become unfashionable.</p>
                                <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                                <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="product-box-3 product-wishlist">
                            <div class="img-wrapper">
                                <div class="label-block"><a class="label-2 wishlist-icon delete-button"
                                        href="javascript:void(0)" title="Add to Wishlist" tabindex="0"><i class="iconsax"
                                            data-icon="trash" aria-hidden="true"></i></a></div>
                                <div class="product-image"><a class="pro-first" href="product.html"> <img class="bg-img"
                                            src="/template/client/assets/images/product/product-3/2.jpg"
                                            alt="product"></a><a class="pro-sec" href="product.html"> <img class="bg-img"
                                            src="/template/client/assets/images/product/product-3/19.jpg"
                                            alt="product"></a></div>
                                <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" title="Add to cart" tabindex="0"><i
                                            class="iconsax" data-icon="basket-2" aria-hidden="true"> </i></a><a
                                        href="compare.html" title="Compare" tabindex="0"><i class="iconsax"
                                            data-icon="arrow-up-down" aria-hidden="true"></i></a><a href="#"
                                        data-bs-toggle="modal" data-bs-target="#quick-view" title="Quick View"
                                        tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="product-detail">
                                <ul class="rating">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-regular fa-star"></i></li>
                                    <li>4.3</li>
                                </ul><a href="product.html">
                                    <h6>Wide Linen-Blend Trousers</h6>
                                </a>
                                <p class="list-per">I was the first person to have a punk rock hairstyle. It is not easy
                                    to dress well. I have my permanent muses and my muses of the moment. We live in an
                                    era of globalization and the era of the woman. Never in the history of the world
                                    have women been more in control of their destiny. You have a more interesting life
                                    if you wear impressive clothes.</p>
                                <p>$100.00 <del>$18.00 </del></p>
                                <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop </a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
