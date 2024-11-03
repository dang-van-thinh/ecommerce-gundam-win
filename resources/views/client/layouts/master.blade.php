<!DOCTYPE html>
<html lang="en">

    <head>
        <title>
            @yield('title')
        </title>
        @include('client.layouts.partials.css')
        @stack('css')

    </head>
    <body class="skeleton_body">
        <!--bottom to top-->
        <div class="tap-top">
            <div>
                <i class="fa-solid fa-angle-up"></i>
            </div>
        </div>
        <!-- hieu ung chuot
        <span class="cursor">
            <span class="cursor-move-inner"><span class="cursor-inner"></span></span><span
                class="cursor-move-outer"><span class="cursor-outer"></span></span>
        </span> -->

        <!-- Load trang trang truoc khi co du lieu-->
        <div class="skeleton_loader">
            @include('client.layouts.partials.header.loader')
        </div>

        <!-- header khi co du lieu-->
        <header>
            <!-- Quảng cáo header -->
            {{-- <div class="top_header">
                <p>Free Coupne Code: Summer Sale On Selected items Use:<span>NEW 26</span><a
                        href="collection-left-sidebar.html"> SHOP NOW</a></p>
            </div> --}}
            <!-- menu logo cac kieu-->
            {{-- @include('client.layouts.partials.header.header-menu') --}}
            <x-header-component />
        </header>
        <!-- content -->
        @yield('content')

        <!--footer-->
        @include('client.layouts.partials.footer')
        <div class="modal theme-modal fade" id="quick-view" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body"><button class="btn-close" type="button" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-xs-12">
                                <div class="quick-view-img">
                                    <div class="swiper modal-slide-1">
                                        <div class="swiper-wrapper ratio_square-2">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/1.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/2.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/3.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/4.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper modal-slide-2">
                                        <div class="swiper-wrapper ratio3_4">
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/5.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/6.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/7.jpg" alt="" />
                                            </div>
                                            <div class="swiper-slide"><img class="bg-img"
                                                    src="/template/client/assets/images/pro/8.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 rtl-text">
                                <div class="product-right">
                                    <h3>Women Pink Shirt</h3>
                                    <h5>$32.96<del>$50.12</del></h5>
                                    <ul class="color-variant">
                                        <li class="bg-color-brown"></li>
                                        <li class="bg-color-chocolate"></li>
                                        <li class="bg-color-coffee"></li>
                                        <li class="bg-color-black"></li>
                                    </ul>
                                    <div class="border-product">
                                        <h6>Product details</h6>
                                        <p>Western yoke on an Indigo shirt made of 100% cotton. Ideal for informal
                                            gatherings, this top will ensure your comfort and style throughout the day.
                                        </p>
                                    </div>
                                    <div class="product-description">
                                        <div class="size-box">
                                            <ul>
                                                <li class="active"><a href="#">s</a></li>
                                                <li><a href="#">m</a></li>
                                                <li><a href="#">l</a></li>
                                                <li><a href="#">xl</a></li>
                                            </ul>
                                        </div>
                                        <h6 class="product-title">Quantity</h6>
                                        <div class="quantity"><button class="minus" type="button"><i
                                                    class="fa-solid fa-minus"></i></button><input type="number"
                                                value="1" min="1" max="20" /><button class="plus"
                                                type="button"><i class="fa-solid fa-plus"></i></button></div>
                                    </div>
                                    <div class="product-buttons"><a class="btn btn-solid" href="cart.html">Add to
                                            cart</a><a class="btn btn-solid" href="product.html">View detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--add cart success-->
        <div class="modal theme-modal fade cart-modal" id="addtocart" tabindex="-1" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body modal1">
                        <div class="custom-container container">
                            <div class="row">
                                <div class="col-12 px-0">
                                    <div class="modal-bg addtocart"><button class="btn-close" type="button"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="d-flex"><a href="#"><img
                                                    class="img-fluid blur-up lazyload pro-img"
                                                    src="/template/client/assets/images/modal/0.jpg"
                                                    alt="" /></a>
                                            <div class="add-card-content align-self-center text-center"><a
                                                    href="#">
                                                    <h6><i class="fa-solid fa-check"> </i>Item <span>men full
                                                            sleeves</span><span> successfully added to your Cart</span>
                                                    </h6>
                                                </a>
                                                <div class="buttons"><a class="view-cart btn btn-solid"
                                                        href="cart.html">Your cart</a><a
                                                        class="checkout btn btn-solid" href="check-out.html">Check
                                                        out</a><a class="continue btn btn-solid"
                                                        href="index.html">Continue shopping</a></div>
                                                <div class="upsell_payment"><img class="img-fluid blur-up lazyload"
                                                        src="/template/client/assets/images/payment_cart.png"
                                                        alt="" /></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-upsell">
                                        <h5>Products Loved by Our Customers</h5><svg>
                                            <use href="/template/client/assets/svg/icon-sprite.svg#main-line"></use>
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/1.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/2.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/3.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/4.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/5.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Woven Jacket</h6>
                                            <p>$25</p>
                                        </a></div>
                                    <div class="card-img"> <img src="/template/client/assets/images/modal/6.jpg"
                                            alt="user" /><a href="#">
                                            <h6>Printed Dresses</h6>
                                            <p>$25</p>
                                        </a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart item
            <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h4><button class="btn-close"
                    type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body theme-scrollbar">
                <ul class="offcanvas-cart">
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/1.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity-previous">2</div>
                                        <div id="quantity-current">3</div>
                                        <div id="quantity-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/2.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total1">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove1">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity1-previous">2</div>
                                        <div id="quantity1-current">3</div>
                                        <div id="quantity1-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add1">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/3.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total2">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove2">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity2-previous">2</div>
                                        <div id="quantity2-current">3</div>
                                        <div id="quantity2-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add2">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/4.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total3">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove3">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity3-previous">2</div>
                                        <div id="quantity3-current">3</div>
                                        <div id="quantity3-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add3">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-footer">
                <p>Spend <span>$ 14.81 </span>more and enjoy <span>FREE SHIPPING!</span></p>
                <div class="footer-range-slider">
                    <div class="progress" role="progressbar" aria-label="Animated striped example"
                        aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated theme-default"
                            style="width: 46%"></div>
                    </div>
                </div>
                <div class="price-box">
                    <h6>Total :</h6>
                    <p>$ 49.59 USD</p>
                </div>
                <div class="cart-button"> <a class="btn btn_outline" href="cart.html"> View Cart</a><a
                        class="btn btn_black" href="check-out.html"> Checkout</a></div>
            </div>
        </div> -->

        <!--Search-->
        @include('client.layouts.components.search')
        {{-- <div class="wrapper show">
            <div class="title-box"> <img src="/template/client/assets/images/other-img/cookie.png"
                    alt="" />
                <h3>Cookies Consent</h3>
            </div>
            <div class="info">
                <p>We use cookies to improve our site and your shopping experience. By continuing to browse our site you
                    accept our cookie policy.</p>
            </div>
            <div class="buttons"><button class="button btn btn_outline sm" id="acceptBtn">Accept</button><button
                    class="button btn btn_black sm">Decline</button></div>
        </div> --}}
        <div class="theme-btns"><button class="btntheme" id="dark-btn"><i class="fa-regular fa-moon"></i>
                <div class="text">Dark</div>
            </button><button class="btntheme rtlBtnEl" id="rtl-btn"><i class="fa-solid fa-repeat"></i>
                <div class="rtl">Rtl</div>
            </button></div>
        <!-- <div class="modal theme-modal newsletter-modal fade" id="newsletter" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content"><button class="btn-close" type="button" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-body p-0">
                    <div class="news-latter-box">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <div class="newslwtter-content"><img class="img-fluid"
                                        src="/template/client/assets/images/other-img/text.png" alt="" />
                                    <h4>Subscriber to Our Newsletter!</h4>
                                    <p>Keep up to date so you don't miss any new updates or goods we reveal.</p>
                                    <div class="form-floating"><input type="text" placeholder="Enter Your Name.." />
                                    </div>
                                    <div class="form-floating"><input type="email" placeholder="Enter Your Email.." />
                                    </div><button class="btn btn-submit" type="submit" data-bs-dismiss="modal"
                                        aria-label="Close">Submit</button>
                                </div>
                            </div>
                            <div class="col-md-6 d-none d-lg-block">
                                <div class="newslwtter-img"> <img class="img-fluid"
                                        src="/template/client/assets/images/other-img/news-latter.png" alt="" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>Bootstrap js -->
        @include('client.layouts.partials.script')
        @stack('scripts')
    </body>

</html>
