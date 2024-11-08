<div class="custom-container container">
    <div class="row">
        <div class="col-xxl-5 col-lg-8 offer-box-1">
            <div class="row gy-4 ratio_45">
                @foreach ($contentLeftTopBanners as $banners)
                <div class="col-12">
                    <div class="collection-banner p-left"> 
                        
                        <img class="bg-img"
                            src="{{ asset('storage/' . $banners->image_url) }}" alt="" />
                        <div class="contain-banners">
                            <div>
                                <h4>Up to 60% OFF</h4>
                                <h3>{{$banners->title}}</h3>
                                <div class="link-hover-anim underline"><a
                                        class="btn btn_underline link-strong link-strong-unhovered"
                                        href="{{$banners->link}}">Shop Collection<svg>
                                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                        href="{{$banners->link}}">Shop Collection<svg>
                                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg></a></div>
                            </div>
                        </div>
                        
                    </div>    
                </div>
                @endforeach
                @foreach ($contentLeftBelowBanners as $banners)             
                <div class="col-12">
                    <div class="collection-banners p-right"><img class="bg-img"
                            src="{{ asset('storage/' . $banners->image_url) }}" alt="" />
                        <div class="contain-banners">
                            <div>
                                <h4>Up to 60% OFF</h4>
                                <h3>{{$banners->title}}</h3>
                                <div class="link-hover-anim underline"><a
                                        class="btn btn_underline link-strong link-strong-unhovered"
                                        href="{{$banners->link}}">Shop Collection<svg>
                                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                        href="{{$banners->link}}">Shop Collection<svg>
                                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow">
                                            </use>
                                        </svg></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-xxl-3 col-4 d-none d-lg-block">
            <div class="special-offer-slider">
                <h4>Sản phẩm yêu thích nhất</h4>
                <div class="swiper special-offer-slide">
                    <div class="swiper-wrapper trending-products">
                        @foreach ($products as $product)
                            <div class="swiper-slide product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                    </div>
                                    <div class="product-image ratio_apos">
                                    <a class="pro-first" href="{{ route('product', $product->id) }}">
                                        <img class="bg-img" src="{{ '/storage/' . $product->image}}" alt="product" />
                                    </a>
                                    @php
                                    $firstImage = $product->productImages->first();
                                    @endphp
                                    <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                        <img class="bg-img" src="{{'/storage/' . $firstImage->image_url}}"
                                            alt="product" />
                                    </a>
                                </div>
                                    <div class="cart-info-icon">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart"
                                            tabindex="0">
                                            <i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to card">
                                            </i>
                                        </a>
                                        {{-- <a href="compare.html" tabindex="0">
                                        <i class="iconsax" data-icon="arrow-up-down" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Compare">
                                        </i>
                                    </a> --}}
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view"
                                            tabindex="0"><i class="iconsax" data-icon="eye" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Quick View">
                                            </i>
                                        </a>
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
                                    </ul><a href="{{ route('product', $product->id) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    <p>
                                        @if ($product->productVariants->count() === 1)
                                            {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                        @else
                                            {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫ -
                                            {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="swiper-slide product-box-3">
                            <div class="img-wrapper">
                                <div class="label-block"><span class="lable-1">NEW</span><a
                                        class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                            class="iconsax" data-icon="heart" aria-hidden="true"
                                            data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                </div>
                                <div class="product-image ratio_apos"><a class="pro-first" href="product.html">
                                        <img class="bg-img" src="/template/client/assets/images/product/product-3/8.jpg"
                                            alt="product" /></a><a class="pro-sec" href="product.html">
                                        <img class="bg-img"
                                            src="/template/client/assets/images/product/product-3/12.jpg"
                                            alt="product" /></a></div>
                                <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#addtocart" tabindex="0"><i class="iconsax" data-icon="basket-2"
                                            aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Add to card">
                                        </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                            data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                            aria-hidden="true" data-bs-toggle="tooltip"
                                            data-bs-title="Quick View"></i></a></div>
                                <div class="countdown">
                                    <ul class="clockdiv2">
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
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-regular fa-star"></i></li>
                                    <li>4.3</li>
                                </ul><a href="product.html">
                                    <h6>Wide Linen-Blend Trousers</h6>
                                </a>
                                <p>$100.00 <del>$18.00 </del></p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
        @foreach ($contentRightBanners as $banner)
        <div class="col-4 d-none d-xxl-block">
            <div class="offer-banners-3 ratio1_3">
                 <a href="{{$banner->link}}"> <img class="bg-img"
                        src="{{ asset('storage/' . $banner->image_url) }}" alt="" />
                    <div> <img src="/template/client/assets/images/banner/2.png" alt="" />
                        <h6>{{$banner->title}}</h6>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
