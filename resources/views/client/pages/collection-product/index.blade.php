@extends('client.layouts.master')
@section('title')
Danh sách sản phẩm
@endsection
@section('content')
@include('client.pages.components.breadcrumb', [
'pageHeader' => 'Danh sách sản phẩm',
'parent' => [
'route' => '',
'name' => 'Trang chủ',
],
]);
<section class="section-b-space pt-0">
    <div class="custom-container container">
        <div class="row">
            <div class="col-3">
                <div class="custom-accordion theme-scrollbar left-box">
                    <div class="left-accordion">
                        <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="search-box"><input type="search" name="text" placeholder="Search here..."><i
                                class="iconsax" data-icon="search-normal-2"></i></div>
                        <div class="accordion-item">
                            <h2 class="accordion-header tags-header"><button class="accordion-button"><span>Applied
                                        Filters</span><span>view all</span></button></h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapse">
                                <div class="accordion-body">
                                    <ul class="tags">
                                        <li> <a href="#">T-Shirt <i class="iconsax" data-icon="add"></i></a></li>
                                        <li> <a href="#">Handbags<i class="iconsax" data-icon="add"></i></a></li>
                                        <li> <a href="#">Trends<i class="iconsax" data-icon="add"></i></a></li>
                                        <li> <a href="#">Minimog<i class="iconsax" data-icon="add"></i></a></li>
                                        <li> <a href="#">Denim<i class="iconsax" data-icon="add"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseEight"><span>Collections</span></button>
                            </h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseEight">
                                <div class="accordion-body">
                                    <ul class="collection-list">
                                        <li> <input class="custom-checkbox" id="category10" type="checkbox"
                                                name="text"><label for="category10">All products</label></li>
                                        <li> <input class="custom-checkbox" id="category11" type="checkbox"
                                                name="text"><label for="category11">Best sellers</label></li>
                                        <li> <input class="custom-checkbox" id="category12" type="checkbox"
                                                name="text"><label for="category12">New arrivals</label></li>
                                        <li> <input class="custom-checkbox" id="category13" type="checkbox"
                                                name="text"><label for="category13">Accessories</label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseTwo"><span>Categories</span></button>
                            </h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseTwo">
                                <div class="accordion-body">
                                    <ul class="catagories-side theme-scrollbar">
                                        <li> <input class="custom-checkbox" id="category1" type="checkbox"
                                                name="text"><label for="category1">Fashion (30)</label></li>
                                        <li> <input class="custom-checkbox" id="category2" type="checkbox"
                                                name="text"><label for="category2">Trends</label></li>
                                        <li> <input class="custom-checkbox" id="category3" type="checkbox"
                                                name="text"><label for="category3">Women’s Shirts</label></li>
                                        <li> <input class="custom-checkbox" id="category4" type="checkbox"
                                                name="text"><label for="category4">Top T-shirt</label></li>
                                        <li> <input class="custom-checkbox" id="category5" type="checkbox"
                                                name="text"><label for="category5">Denim (8)</label></li>
                                        <li> <input class="custom-checkbox" id="category6" type="checkbox"
                                                name="text"><label for="category6">Grains & Beans (8)</label></li>
                                        <li> <input class="custom-checkbox" id="category7" type="checkbox"
                                                name="text"><label for="category7">Cosmopolis</label></li>
                                        <li> <input class="custom-checkbox" id="category8" type="checkbox"
                                                name="text"><label for="category8">Metropolis</label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseFour"><span>Filter</span></button></h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseFour">
                                <div class="accordion-body">
                                    <div class="range-slider"><input class="range-slider-input" type="range" min="0"
                                            max="120000" step="1" value="20000"><input class="range-slider-input"
                                            type="range" min="0" max="120000" step="1" value="100000">
                                        <div class="range-slider-display"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne"><span>Color</span></button></h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseOne">
                                <div class="accordion-body">
                                    <div class="color-box">
                                        <ul class="color-variant">
                                            <li class="bg-color-purple"></li>
                                            <li class="bg-color-blue"></li>
                                            <li class="bg-color-red"></li>
                                            <li class="bg-color-yellow"></li>
                                            <li class="bg-color-coffee"></li>
                                            <li class="bg-color-chocolate"></li>
                                            <li class="bg-color-brown"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseSix"><span>Availability</span></button>
                            </h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSix">
                                <div class="accordion-body">
                                    <ul class="catagories-side">
                                        <li> <input class="custom-radio" id="category9" type="radio" checked="checked"
                                                name="radio"><label for="category9">In
                                                Stock(3)</label></li>
                                        <li> <input class="custom-radio" id="category14" type="radio"
                                                name="radio"><label for="category14">Out Of Stock(1)</label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header tags-header"><button class="accordion-button"><span>Shipping
                                        & Delivery</span><span></span></button></h2>
                            <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSeven">
                                <div class="accordion-body">
                                    <ul class="widget-card">
                                        <li><i class="iconsax" data-icon="truck-fast"></i>
                                            <div>
                                                <h6>Free Shipping</h6>
                                                <p>Free shipping for all US order</p>
                                            </div>
                                        </li>
                                        <li><i class="iconsax" data-icon="headphones"></i>
                                            <div>
                                                <h6>Support 24/7</h6>
                                                <p>Free shipping for all US order</p>
                                            </div>
                                        </li>
                                        <li><i class="iconsax" data-icon="exchange"></i>
                                            <div>
                                                <h6>30 Days Return</h6>
                                                <p>Free shipping for all US order</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="sticky">
                    <div class="top-filter-menu">
                        <div> <a class="filter-button btn">
                                <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                            </a>
                            <div class="category-dropdown"><label for="cars">Sort By :</label><select
                                    class="form-select" id="cars" name="carlist">
                                    <option value="">Best selling</option>
                                    <option value="">Popularity</option>
                                    <option value="">Featured</option>
                                    <option value="">Alphabetically, Z-A</option>
                                    <option value="">High - Low Price</option>
                                    <option value="">% Off - Hight To Low</option>
                                </select></div>
                        </div>
                        {{-- <ul class="filter-option-grid">
                            <li class="nav-item d-none d-md-flex"> <button class="nav-link" data-grid="2"><svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#grid-2"></use>
                                    </svg></button></li>
                            <li class="nav-item d-none d-md-flex"> <button class="nav-link" data-grid="3"><svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#grid-3"></use>
                                    </svg></button></li>
                            <li class="nav-item d-none d-lg-flex"> <button class="nav-link active" data-grid="4"><svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#grid-4"></use>
                                    </svg></button></li>
                            <li class="nav-item d-none d-md-flex"> <button class="nav-link" data-grid="list"><svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#grid-list"></use>
                                    </svg></button></li>
                        </ul> --}}
                    </div>
                    <div class="product-tab-content ratio1_3">
                        <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4">
                            @foreach($products as $product)
                            <div>
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        <div class="label-block">
                                            <a class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0">
                                                <i class="iconsax" data-icon="heart" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i>
                                            </a>
                                        </div>
                                        <div class="product-image">
                                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $product->image}}"
                                                    alt="product">
                                            </a>
                                            @php
                                            $firstImage = $product->productImages->first();
                                            @endphp
                                            <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                    alt="product">
                                            </a>
                                        </div>
                                        <div class="cart-info-icon">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart" tabindex="0">
                                                <i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Add to card"> </i>
                                            </a>
                                        </div>

                                        <!--Dem nguoc thoi gian voucher-->
                                        <!-- <div class="countdown">
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
                                                                                    </div> -->
                                    </div>
                                    <div class="product-detail">
                                        <ul class="rating">
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4.3</li>
                                        </ul>
                                        <a href="{{ route('product', $product->id) }}">
                                            <h6>{{$product->name}}</h6>
                                        </a>
                                        <p>
                                            @if ($product->productVariants->count() === 1)
                                            {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                            @else
                                            {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫ -
                                            {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
                                            @endif
                                            {{-- <span>-20%</span> --}}
                                        </p>
                                        <div class="listing-button"> <a class="btn" href="cart.html">Quick Shop
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!--Pani nay thi su dung theo cai tra ra du lieu nhe-->
                    <div class="pagination-wrap">
                        <ul class="pagination">
                            <li> <a class="prev" href="#"><i class="iconsax" data-icon="chevron-left"></i></a></li>
                            <li> <a href="#">1</a></li>
                            <li> <a class="active" href="#">2</a></li>
                            <li> <a href="#">3 </a></li>
                            <li> <a class="next" href="#"> <i class="iconsax" data-icon="chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection