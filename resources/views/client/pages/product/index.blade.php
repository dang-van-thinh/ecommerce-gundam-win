@extends('client.layouts.master')
@section('title')
    Chi tiết sản phẩm
@endsection
@push('css')
    <style>
        /* Flex container settings */
        .d-flex.flex-column {
            gap: 15px;
            margin-top: 20px;
        }

        .d-flex.flex-row {
            align-items: center;
            margin-bottom: 10px;
        }

        /* Heading styling */
        .d-flex.flex-row h5 {
            margin-right: 15px;
            margin-top: 10px;
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        /* List and button styles */
        .box ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 10px;
        }

        .box ul button {
            width: 100px;
            height: 30px;
            padding: 0;
        }

        .variant-option {
            padding: 10px;
            background-color: white;
            border: 1px solid #f5f5f5;
            border-radius: 4px;
            margin-right: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .variant-option:hover {
            border-color: #ff6f61;
            color: red;
        }

        /* Selected variant style */
        .variant-option.selected {
            background-color: #333;
            color: #fff;
            border-color: #333;
        }
    </style>
@endpush
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Sản phẩm : ' . $product->name,
        'parent' => [
            'route' => route('home'),
            'name' => 'Trang chủ',
        ],
    ])
    <section class="section-b-space product-thumbnail-page pt-0">
        <div class="custom-container container">
            <div class="row gy-4">
                <div class="col-lg-6">
                    <div class="row sticky">
                        <div class="col-sm-2 col-3">
                            <div class="swiper product-slider product-slider-img">
                                <div class="swiper-wrapper">
                                    @foreach ($product->productImages as $productImage)
                                        <div class="swiper-slide">
                                            <img src="{{ '/storage/' . $productImage->image_url }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 col-9">
                            <div class="swiper product-slider-thumb product-slider-img-1">
                                <div class="swiper-wrapper ratio_square-2">
                                    @foreach ($product->productImages as $productImage)
                                        <div class="swiper-slide">
                                            <img class="bg-img" src="{{ '/storage/' . $productImage->image_url }}"
                                                alt="">
                                            @if ($product->status === 'IN_ACTIVE')
                                                <!-- Lớp phủ cho sản phẩm hết hàng -->
                                                <div
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                                                    background-color: rgba(0, 0, 0, 0.6); display: flex; 
                                                    justify-content: center; align-items: center; color: #fff; 
                                                    font-size: 25px; font-weight: bold; z-index: 5;">
                                                    NGƯNG BÁN
                                                </div>
                                            @elseif ($product->is_out_of_stock)
                                                <!-- Lớp phủ cho sản phẩm ngưng bán -->
                                                <div
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                                                    background-color: rgba(0, 0, 0, 0.6); display: flex; 
                                                    justify-content: center; align-items: center; color: #fff; 
                                                    font-size: 25px; font-weight: bold; z-index: 5;">
                                                    HẾT HÀNG
                                                </div>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-detail-box">
                        <div class="product-option">
                            <div class="move-fast-box d-flex align-items-center gap-1"><img
                                    src="/template/client/assets/images/gif/fire.gif" alt="">
                                <p>Move fast!</p>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p id="variant-price">
                                @if ($product->productVariants->count() === 1)
                                    {{ number_format($product->productVariants->first()->price, 0, ',', '.') }} VND
                                @else
                                    {{ number_format($product->productVariants->min('price'), 0, ',', '.') }} -
                                    {{ number_format($product->productVariants->max('price'), 0, ',', '.') }} VND
                                @endif
                                {{-- <span class="offer-btn">25% off</span> --}}
                            </p>
                            <div class="rating">
                                <ul>
                                    @php
                                        $rating = $averageRating ? $averageRating : 0; // Lấy rating từ feedback
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i class="fa-solid fa-star"
                                                style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                        </li>
                                    @endfor
                                    <li><span>({{ $feedbackCount }}) đánh giá</span></li>
                                </ul>
                            </div>
                            <div class="buy-box border-buttom">
                                {{-- <ul>
                                    <li> <span data-bs-toggle="modal" data-bs-target="#size-chart" title="Quick View"
                                            tabindex="0"><i class="iconsax me-2" data-icon="ruler"></i>Bảng kích
                                            thước</span>
                                    </li>
                                    <li>
                                        <span data-bs-toggle="modal" data-bs-target="#terms-conditions-modal"
                                            title="Quick View" tabindex="0"><i class="iconsax me-2"
                                                data-icon="truck"></i>Giao hàng và trả lại</span>
                                    </li>
                                    <li>
                                        <span data-bs-toggle="modal" data-bs-target="#question-box" title="Quick View"
                                            tabindex="0"><i class="iconsax me-2" data-icon="question-message"></i>Đặt câu
                                            hỏi
                                        </span>
                                    </li>
                                </ul> --}}
                            </div>
                            @if ($product->status !== 'IN_ACTIVE')
                                <div class="d-flex flex-column">
                                    <div class="product-variants">
                                        {{-- hien thi bien the san pham --}}
                                        @foreach ($productAttribute as $index => $variant)
                                            <div class="d-flex flex-row">
                                                <h5 class=""> {{ $variant['name'] }} </h5>
                                                <div class="box">
                                                    <ul class="variant" id="variant-options">
                                                        @foreach ($variant['value'] as $key => $item)
                                                            {{-- @dd($item) --}}
                                                            <button class="variant-option"
                                                                data-variant="{{ $variant['name'] }}"
                                                                data-value="{{ $item['id'] }}" data-quantity="">
                                                                {{ $item['name'] }}
                                                            </button>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div>
                                            <h5 class="fw-bold">Số lượng :
                                                <span class="fw-bold fs-6" id="variant-quantity"></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="quantity-box d-flex align-items-center gap-3">
                                    <div class="quantity">
                                        <button class="minus" type="button">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                        <input type="number" value="1" min="1" max=""
                                            id="quantity_variant">
                                        <button class="plus" type="button">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex align-items-center w-100 gap-3">
                                        <button type="button" id="btn_add_to_cart" class="btn btn_black sm"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                            aria-controls="offcanvasRight">
                                            Thêm Vào Giỏ Hàng
                                        </button>
                                        <button type="button" id="btn_buy_now" class="btn btn_black sm"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                            aria-controls="offcanvasRight">
                                            Mua ngay
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="quantity-box d-flex align-items-center gap-3">
                                    <h3 class="text-danger">Sản phẩm hiện ngưng bán</h3>
                                </div>
                            @endif
                            <div class="buy-box">
                                <ul>
                                    <li>
                                        <a class="label-2 wishlist-icon" data-id="{{ $product->id }}" tabindex="0">
                                            <i class="fa-regular fa-heart"
                                                style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }};padding: 0 20px;font-size: 1.2em;  "></i>
                                            <i class="fa-solid fa-heart"
                                                style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }};padding: 0 20px;font-size: 1.2em; "></i>
                                        </a>
                                        <span style="font-size: 1.2em;"
                                            class="wishlist-text">{{ $product->favorites->isNotEmpty() ? 'Bỏ yêu thích' : 'Yêu thích sản phẩm' }}</span>
                                    </li>
                                    {{-- <li> <a href="compare.html"> <i class="fa-solid fa-arrows-rotate me-2"></i>Add To
                                        Compare</a></li>
                                <li> <a href="#" data-bs-toggle="modal" data-bs-target="#social-box" title="Quick View"
                                        tabindex="0"><i class="fa-solid fa-share-nodes me-2"></i>Share</a></li> --}}
                                </ul>
                            </div>
                            <div class="sale-box" style="text-align: start;width: auto;">
                                <ul class="d-grid gap-3">
                                    <li class="d-flex">
                                        <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M18.5 18C18.5 19.1046 17.6046 20 16.5 20C15.3954 20 14.5 19.1046 14.5 18M18.5 18C18.5 16.8954 17.6046 16 16.5 16C15.3954 16 14.5 16.8954 14.5 18M18.5 18H21.5M14.5 18H13.5M8.5 18C8.5 19.1046 7.60457 20 6.5 20C5.39543 20 4.5 19.1046 4.5 18M8.5 18C8.5 16.8954 7.60457 16 6.5 16C5.39543 16 4.5 16.8954 4.5 18M8.5 18H13.5M4.5 18C3.39543 18 2.5 17.1046 2.5 16V7.2C2.5 6.0799 2.5 5.51984 2.71799 5.09202C2.90973 4.71569 3.21569 4.40973 3.59202 4.21799C4.01984 4 4.5799 4 5.7 4H10.3C11.4201 4 11.9802 4 12.408 4.21799C12.7843 4.40973 13.0903 4.71569 13.282 5.09202C13.5 5.51984 13.5 6.0799 13.5 7.2V18M13.5 18V8H17.5L20.5 12M20.5 12V18M20.5 12H13.5"
                                                    stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <h6 class="fw-bold">Vận chuyển miễn phí</h6>
                                            <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                        </div>
                                    </li>
                                    <li class="d-flex jus">
                                        <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M14.05 6C15.0268 6.19057 15.9244 6.66826 16.6281 7.37194C17.3318 8.07561 17.8095 8.97326 18 9.95M14.05 2C16.0793 2.22544 17.9716 3.13417 19.4163 4.57701C20.8609 6.01984 21.7721 7.91101 22 9.94M18.5 21C9.93959 21 3 14.0604 3 5.5C3 5.11378 3.01413 4.73086 3.04189 4.35173C3.07375 3.91662 3.08968 3.69907 3.2037 3.50103C3.29814 3.33701 3.4655 3.18146 3.63598 3.09925C3.84181 3 4.08188 3 4.56201 3H7.37932C7.78308 3 7.98496 3 8.15802 3.06645C8.31089 3.12515 8.44701 3.22049 8.55442 3.3441C8.67601 3.48403 8.745 3.67376 8.88299 4.05321L10.0491 7.26005C10.2096 7.70153 10.2899 7.92227 10.2763 8.1317C10.2643 8.31637 10.2012 8.49408 10.0942 8.64506C9.97286 8.81628 9.77145 8.93713 9.36863 9.17882L8 10C9.2019 12.6489 11.3501 14.7999 14 16L14.8212 14.6314C15.0629 14.2285 15.1837 14.0271 15.3549 13.9058C15.5059 13.7988 15.6836 13.7357 15.8683 13.7237C16.0777 13.7101 16.2985 13.7904 16.74 13.9509L19.9468 15.117C20.3262 15.255 20.516 15.324 20.6559 15.4456C20.7795 15.553 20.8749 15.6891 20.9335 15.842C21 16.015 21 16.2169 21 16.6207V19.438C21 19.9181 21 20.1582 20.9007 20.364C20.8185 20.5345 20.663 20.7019 20.499 20.7963C20.3009 20.9103 20.0834 20.9262 19.6483 20.9581C19.2691 20.9859 18.8862 21 18.5 21Z"
                                                    stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <h6 class="fw-bold">Hỗ trợ 24/7</h6>
                                            <p>Hỗ trợ tư vấn, giải đáp thắc mắc khách hàng 24/7</p>
                                        </div>
                                    </li>
                                    <li class="d-flex">
                                        <svg width="35px" height="35px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                            </g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M4 8L3.29289 8.70711L2.58579 8L3.29289 7.29289L4 8ZM9 20C8.44772 20 8 19.5523 8 19C8 18.4477 8.44772 18 9 18L9 20ZM8.29289 13.7071L3.29289 8.70711L4.70711 7.29289L9.70711 12.2929L8.29289 13.7071ZM3.29289 7.29289L8.29289 2.29289L9.70711 3.70711L4.70711 8.70711L3.29289 7.29289ZM4 7L14.5 7L14.5 9L4 9L4 7ZM14.5 20L9 20L9 18L14.5 18L14.5 20ZM21 13.5C21 17.0898 18.0898 20 14.5 20L14.5 18C16.9853 18 19 15.9853 19 13.5L21 13.5ZM14.5 7C18.0899 7 21 9.91015 21 13.5L19 13.5C19 11.0147 16.9853 9 14.5 9L14.5 7Z"
                                                    fill="#33363F"></path>
                                            </g>
                                        </svg>
                                        <div class="ms-3">
                                            <h6 class="fw-bold">Hoàn hàng trong 3 ngày</h6>
                                            <p>Hoàn hàng miễn phí vận chuyển trong thời gian 3 ngày</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            {{-- <div class="dz-info">
                            <ul>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6>Sku:</h6>
                                        <p> SKU_45 </p>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6>Available: </h6>
                                        <p>Pre-Order</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6>Tags: </h6>
                                        <p>Color Pink Clay , Athletic, Accessories, Vendor Kalles</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center gap-2">
                                        <h6>Vendor: </h6>
                                        <p> Balenciaga</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="share-option">
                            <h5>Secure Checkout </h5><img class="img-fluid"
                                src="/template/client/assets/images/other-img/secure_payments.png" alt="">
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-section-box x-small-section pt-0">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-12">
                        <ul class="product-tab theme-scrollbar nav nav-tabs nav-underline" id="Product" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                    data-bs-target="#Description-tab-pane" role="tab"
                                    aria-controls="Description-tab-pane" aria-selected="true">Chi tiết sản
                                    phẩm</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation"><button class="nav-link" id="specification-tab"
                                data-bs-toggle="tab" data-bs-target="#specification-tab-pane" role="tab"
                                aria-controls="specification-tab-pane" aria-selected="false">Thông số kỹ thuật</button>
                        </li>
                        <li class="nav-item" role="presentation"><button class="nav-link" id="question-tab"
                                data-bs-toggle="tab" data-bs-target="#question-tab-pane" role="tab"
                                aria-controls="question-tab-pane" aria-selected="false">Q & A</button></li> --}}
                            <li class="nav-item" role="presentation"><button class="nav-link" id="Reviews-tab"
                                    data-bs-toggle="tab" data-bs-target="#Reviews-tab-pane" role="tab"
                                    aria-controls="Reviews-tab-pane" aria-selected="false">Đánh giá sản phẩm</button></li>
                        </ul>
                        <div class="tab-content product-content" id="ProductContent">
                            <div class="tab-pane fade show active" id="Description-tab-pane" role="tabpanel"
                                aria-labelledby="Description-tab" tabindex="0">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="tab-pane fade" id="specification-tab-pane" role="tabpanel"
                            aria-labelledby="specification-tab" tabindex="0">
                            <p>I like to be real. I don't like things to be staged or fussy. Grunge is a hippied
                                romantic version of punk. I have my favourite fashion decade, yes, yes, yes: '60s.
                                It was a sort of little revolution; the clothes were amazing but not too
                                exaggerated. Fashions fade, style is eternal. A girl should be two things: classy
                                and fabulous.</p>
                            <div class="table-responsive theme-scrollbar">
                                <table class="specification-table striped table">
                                    <tr>
                                        <th>Product Dimensions</th>
                                        <td>15 x 15 x 3 cm; 250 Grams</td>
                                    </tr>
                                    <tr>
                                        <th>Date First Available</th>
                                        <td>5 April 2021</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer&rlm;</th>
                                        <td>Aditya Birla Fashion and Retail Limited</td>
                                    </tr>
                                    <tr>
                                        <th>ASIN</th>
                                        <td>B06Y28LCDN</td>
                                    </tr>
                                    <tr>
                                        <th>Item model number</th>
                                        <td>AMKP317G04244</td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>Men</td>
                                    </tr>
                                    <tr>
                                        <th>Item Weight</th>
                                        <td>250 G</td>
                                    </tr>
                                    <tr>
                                        <th>Item Dimensions LxWxH</th>
                                        <td>15 x 15 x 3 Centimeters</td>
                                    </tr>
                                    <tr>
                                        <th>Net Quantity</th>
                                        <td>1 U</td>
                                    </tr>
                                    <tr>
                                        <th>Included Components&rlm;</th>
                                        <td>1-T-shirt</td>
                                    </tr>
                                    <tr>
                                        <th>Generic Name</th>
                                        <td>T-shirt</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="question-tab-pane" role="tabpanel" aria-labelledby="question-tab"
                            tabindex="0">
                            <div class="question-main-box">
                                <h5>Have Doubts Regarding This Product ?</h5>
                                <h6 data-bs-toggle="modal" data-bs-target="#question-modal" title="Quick View"
                                    tabindex="0">Post Your Question</h6>
                            </div>
                            <div class="question-answer">
                                <ul>
                                    <li>
                                        <div class="question-box">
                                            <p>Q1 </p>
                                            <h6>Which designer created the little black dress?</h6>
                                            <ul class="link-dislike-box">
                                                <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                </li>
                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                        </i>0</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="answer-box"><b>Ans.</b><span>The little black dress (LBD) is
                                                often attributed to the iconic fashion designer Coco Chanel. She
                                                popularized the concept of the LBD in the 1920s, offering a simple,
                                                versatile, and elegant garment that became a staple in women's
                                                fashion.</span></div>
                                    </li>
                                    <li>
                                        <div class="question-box">
                                            <p>Q2 </p>
                                            <h6>Which First Lady influenced women's fashion in the 1960s?</h6>
                                            <ul class="link-dislike-box">
                                                <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                </li>
                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                        </i>0</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="answer-box"><b>Ans.</b><span>The First Lady who significantly
                                                influenced women's fashion in the 1960s was Jacqueline Kennedy, the
                                                wife of President John F. Kennedy. She was renowned for her elegant
                                                and sophisticated style, often wearing simple yet chic outfits that
                                                set trends during her time in the White House. </span></div>
                                    </li>
                                    <li>
                                        <div class="question-box">
                                            <p>Q3 </p>
                                            <h6>What was the first name of the fashion designer Chanel?</h6>
                                            <ul class="link-dislike-box">
                                                <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0
                                                    </a>
                                                </li>
                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                        </i>0</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="answer-box"><b>Ans.</b><span>The first name of the fashion
                                                designer Chanel was Gabrielle. Gabrielle "Coco" Chanel was a
                                                pioneering French fashion designer known for her timeless designs,
                                                including the iconic Chanel suit and the little black dress.</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="question-box">
                                            <p>Q4 </p>
                                            <h6>Carnaby Street, famous in the 60s as a fashion center, is in which
                                                capital?</h6>
                                            <ul class="link-dislike-box">
                                                <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                </li>
                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                        </i>0</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="answer-box"><b>Ans.</b><span>Carnaby Street, famous for its
                                                association with fashion and youth culture in the 1960s, is located
                                                in London, the capital of the United Kingdom.🎉</span></div>
                                    </li>
                                    <li>
                                        <div class="question-box">
                                            <p>Q5 </p>
                                            <h6>Threadless is a company selling unique what?</h6>
                                            <ul class="link-dislike-box">
                                                <li> <a href="#"><i class="iconsax" data-icon="like"> </i>0</a>
                                                </li>
                                                <li> <a href="#"><i class="iconsax" data-icon="dislike">
                                                        </i>0</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="answer-box"><b>Ans.</b><span>Threadless is a company selling
                                                unique T-shirts.</span></div>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                            <div class="tab-pane fade" id="Reviews-tab-pane" role="tabpanel"
                                aria-labelledby="Reviews-tab" tabindex="0">
                                <div class="row gy-4">
                                    <div class="col-lg-4">
                                        <div class="review-right">
                                            <div class="customer-rating">
                                                <div class="global-rating">
                                                    <div>
                                                        <h5>{{ $averageRating }}</h5>
                                                    </div>
                                                    <div>
                                                        <h6>Đánh giá trung bình</h6>
                                                        <ul class="rating mb p-0">
                                                            @php
                                                                $rating = $averageRating ? $averageRating : 0; // Lấy rating từ feedback
                                                            @endphp
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <li>
                                                                    <i class="fa-solid fa-star"
                                                                        style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                                                </li>
                                                            @endfor
                                                            @php
                                                                $feedbackCount = $feedbacks->count();
                                                            @endphp
                                                            <li><span>({{ $feedbackCount }})</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <ul class="rating-progess">
                                                    @foreach ($ratingProgress as $stars => $percentage)
                                                        <li>
                                                            <p>{{ $stars }} Sao</p>
                                                            <div class="progress" role="progressbar"
                                                                aria-label="Progress for {{ $stars }} stars"
                                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                    style="width: {{ $percentage }}%;"></div>
                                                            </div>
                                                            <p>{{ $percentage }}%</p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                {{-- <button class="btn reviews-modal" data-bs-toggle="modal"
                                                data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Viết Bài
                                                Đánh Giá
                                            </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="comments-box">
                                            <h5>Bình Luận </h5>
                                            <ul class="theme-scrollbar">
                                                @foreach ($feedbacks as $feedback)
                                                    @include('client.pages.product.feedback_product_render')
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container product-contain container">
            <div class="title text-start">
                <h3>Sản phẩm liên quan</h3><svg>
                    <use href="/template/client/assets/svg/icon-sprite.svg#main-line"></use>
                </svg>
            </div>
            <div class="swiper special-offer-slide-2">
                <div class="swiper-wrapper ratio1_3">
                    @foreach ($relatedProducts as $product)
                        <div class="swiper-slide">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block">
                                        <span class="lable-1">Liên quan</span>
                                        <a class="label-2 wishlist-icon" data-id="{{ $product->id }}" tabindex="0">
                                            <i class="fa-regular fa-heart"
                                                style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                            <i class="fa-solid fa-heart"
                                                style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                                        </a>
                                    </div>
                                    <div class="product-image">
                                        <a class="pro-first" href="{{ route('product', $product->id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $product->image }}"
                                                alt="product">
                                        </a>
                                        @php
                                            $firstImage = $product->productImages->first();
                                        @endphp
                                        <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                alt="product">
                                        </a>
                                        @if ($product->is_out_of_stock)
                                            <!-- Lớp phủ cho sản phẩm hết hàng -->
                                            <div
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                                                background-color: rgba(0, 0, 0, 0.6); display: flex; 
                                                justify-content: center; align-items: center; color: #fff; 
                                                font-size: 25px; font-weight: bold; z-index: 10;">
                                                HẾT HÀNG
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cart-info-icon">
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        @php
                                            $rating = $product->average_rating ? ceil($product->average_rating) : 0; // Lấy rating từ feedback
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            <li>
                                                <i class="fa-solid fa-star"
                                                    style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                            </li>
                                        @endfor
                                    </ul>
                                    <a href="{{ route('product', $product->id) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    <p>
                                        @if ($product->productVariants->count() === 1)
                                            {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}
                                            VND
                                        @else
                                            {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}
                                            -
                                            {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}
                                            VND
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="swiper-slide">
                    <div class="product-box-3">
                        <div class="img-wrapper">
                            <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon"
                                    href="javascript:void(0)" tabindex="0"><i class="iconsax" data-icon="heart"
                                        aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Add to Wishlist"></i></a></div>
                            <div class="product-image"><a class="pro-first" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/18.jpg"
                                        alt="product"></a><a class="pro-sec" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/22.jpg" alt="product"></a>
                            </div>
                            <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart"
                                    tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                    </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                        data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                        aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
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
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="product-box-3">
                        <div class="img-wrapper">
                            <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon"
                                    href="javascript:void(0)" tabindex="0"><i class="iconsax" data-icon="heart"
                                        aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Add to Wishlist"></i></a></div>
                            <div class="product-image"><a class="pro-first" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/12.jpg"
                                        alt="product"></a><a class="pro-sec" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/10.jpg" alt="product"></a>
                            </div>
                            <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart"
                                    tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                    </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                        data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                        aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                            </div>
                        </div>
                        <div class="product-detail">
                            <ul class="rating">
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li><i class="fa-solid fa-star"></i></li>
                                <li>4.3</li>
                            </ul><a href="product.html">
                                <h6>Long Sleeve Rounded T-Shirt</h6>
                            </a>
                            <p>$120.30 <del>$140.00</del><span>-20%</span></p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="product-box-3">
                        <div class="img-wrapper">
                            <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon"
                                    href="javascript:void(0)" tabindex="0"><i class="iconsax" data-icon="heart"
                                        aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Add to Wishlist"></i></a></div>
                            <div class="product-image"><a class="pro-first" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/16.jpg"
                                        alt="product"></a><a class="pro-sec" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/20.jpg" alt="product"></a>
                            </div>
                            <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart"
                                    tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                    </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                        data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                        aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                            </div>
                            <div class="countdown">
                                <ul class="clockdiv11">
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
                                <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                <li>4.3</li>
                            </ul><a href="product.html">
                                <h6>Blue lined White T-Shirt</h6>
                            </a>
                            <p>$190.00 <del>$210.00</del></p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="product-box-3">
                        <div class="img-wrapper">
                            <div class="label-block"><span class="lable-1">NEW</span><a class="label-2 wishlist-icon"
                                    href="javascript:void(0)" tabindex="0"><i class="iconsax" data-icon="heart"
                                        aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Add to Wishlist"></i></a></div>
                            <div class="product-image"><a class="pro-first" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/22.jpg"
                                        alt="product"></a><a class="pro-sec" href="product.html"> <img class="bg-img"
                                        src="/template/client/assets/images/product/product-3/12.jpg" alt="product"></a>
                            </div>
                            <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal" data-bs-target="#addtocart"
                                    tabindex="0"><i class="iconsax" data-icon="basket-2" aria-hidden="true"
                                        data-bs-toggle="tooltip" data-bs-title="Add to cart">
                                    </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                        data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                        data-bs-title="Compare"></i></a><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#quick-view" tabindex="0"><i class="iconsax" data-icon="eye"
                                        aria-hidden="true" data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                            </div>
                            <div class="countdown">
                                <ul class="clockdiv10">
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
                            </ul><a href="product.html">
                                <h6>Greciilooks Women's Stylish Top</h6>
                            </a>
                            <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                        </div>
                    </div>
                </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let quantityInput;
        let defaultPrice;
        var resultProduct

        let dataProductVariant = {!! $productVariantJson !!}
        console.log(dataProductVariant);


        document.addEventListener('DOMContentLoaded', function() {
            defaultPrice = document.getElementById('variant-price').textContent;
            quantityInput = document.getElementById("quantity_variant");
            const defaultQuantity = 0;

            console.log(defaultQuantity);
            let arrVariant = [];

            // Lắng nghe sự kiện click trên từng nút variant-option
            document.querySelectorAll('.variant-option').forEach(function(button) {
                button.addEventListener('click', function() {
                    // kiem tra ton tai roi thi bỏ đi

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected'); // xoa bo di
                        document.getElementById('variant-price').textContent =
                            defaultPrice; // set gia voi so luong


                        const variant = this.getAttribute('data-variant');
                        const valueVariant = this.getAttribute('data-value')
                        const index = arrVariant.findIndex(item => item.variant === variant);
                        if (index !== -1) {
                            // Xóa đối tượng được tìm thấy
                            arrVariant.splice(index, 1);
                        }
                        changeVariant(arrVariant);

                        // document.getElementById('variant-quantity').textContent = defaultQuantity;
                        // const variantId = this.getAttribute('data-variant');

                    } else { // con chua bam trc đấy
                        this.closest('.variant').querySelectorAll('.variant-option').forEach(
                            function(btn) {
                                btn.classList.remove('selected');
                            });

                        this.classList.add('selected');


                        const variant = this.getAttribute('data-variant');
                        const valueVariant = this.getAttribute('data-value')
                        const data = {
                            'variant': variant,
                            'valueId': valueVariant
                        };

                        // Tìm doio tuong lap gia tri , neu thay thif thay doi gia tri , chua co thif them moiw
                        result = arrVariant.find(item => item.variant ===
                            variant);
                        if (result) {
                            result.valueId = valueVariant;
                        } else {
                            arrVariant.push(data)
                        }
                        // console.log(arrVariant);
                        // ham thay doi gia tri bien the
                        changeVariant(arrVariant);

                        // const quantity = this.getAttribute('data-quantity');
                        // document.getElementById('variant-price').textContent = price;
                        // document.getElementById('variant-quantity').textContent = quantity;
                        // quantityInput.setAttribute('max', quantity);
                        // quantityInput.value = 1;
                    }
                });
            });

            // thay doi so luong theo bine the
            function changeVariant(dataArrayVariant) {
                console.log(dataArrayVariant);
                console.log("=============");
                console.log(dataProductVariant);
                // set lai gia tri quantity va price
                resultProduct = findMatchingQuantity(dataArrayVariant, dataProductVariant);
                console.log(resultProduct);
                if (resultProduct.length > 0) {
                    let quantityValue = resultProduct[0].quantity;
                    let priceValue = resultProduct[0].price;

                    if (quantityValue == 0) {
                        quantityInput.setAttribute('max', 0);
                        document.getElementById('variant-quantity').textContent = "Sản phẩm này đã hết hàng";
                        document.getElementById('variant-quantity').style.color = 'red'
                    } else {
                        quantityInput.setAttribute('max', quantityValue);
                        document.getElementById('variant-quantity').textContent = quantityValue;
                        document.getElementById('variant-quantity').style.color = 'gray'
                    }

                    quantityInput.value = 1;
                    document.getElementById('variant-price').textContent = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND',
                        currencyDisplay: 'code'
                    }).format(priceValue);
                } else {
                    console.log("nho hon 0");
                    document.getElementById('variant-quantity').textContent = '';
                }
                // console.log(resultProduct); // Kết quả sẽ là mảng số lượng của các biến thể
            }

            function findMatchingQuantity(arrayA, arrayB) {
                return arrayB.filter(product => {
                    // Đảm bảo số lượng các thuộc tính phải trùng nhau
                    if (arrayA.length !== product.attribute_values.length) {
                        return false;
                    }

                    // Kiểm tra nếu tất cả các đối tượng trong arrayA đều có trong attribute_values của product
                    return arrayA.every(variant => {
                        return product.attribute_values.some(attr =>
                            attr.attribute.name === variant.variant &&
                            attr.pivot.attribute_value_id == variant.valueId
                        );
                    });
                }).map(product => ({
                    id: product.id,
                    quantity: product.quantity,
                    price: product.price
                }));
            }

            // Sự kiện khi click nút "Thêm vào giỏ hàng"
            document.querySelector('#btn_add_to_cart').addEventListener("click", function() {
                checklogin('Vui lòng chọn biến thể trước khi thêm giỏ hàng', 'add_to_cart');
            });

            // Sự kiện khi click nút "Mua ngay"
            document.querySelector('#btn_buy_now').addEventListener("click", function() {
                checklogin('Vui lòng chọn biến thể trước khi mua', 'buy_now');
            });
        });

        function checklogin(message, action) {
            @auth
            let selectedVariant = document.querySelector('.variant-option.selected');
            if (!selectedVariant || resultProduct.length == 0) {
                Swal.fire(message, "", "warning");
                return;
            }

            const maxQuantity = parseInt(document.getElementById('variant-quantity').textContent);
            const quantityValue = parseInt(quantityInput.value);

            // console.log(quantityValue);
            // console.log(maxQuantity);

            if (quantityValue > maxQuantity) {
                Swal.fire(`Số lượng không được vượt quá ${maxQuantity}`, "", "warning");
                quantityInput.value = maxQuantity;
                return;
            }
            if (quantityValue < 1) {
                Swal.fire(`Số lượng không được nhỏ hơn 1`, "", "warning");
                quantityInput.value = 1;
                return;
            }
            if (isNaN(maxQuantity)) {
                Swal.fire("Sản phẩm không còn hàng !", "", "warning");
                quantityInput.value = '';
                return;
            }

            const data = {
                userId: {{ Auth::id() }},
                variantId: resultProduct[0].id,
                quantity: quantityValue,
            };

            if (action === 'add_to_cart') {
                sendToCart(data);
            } else if (action === 'buy_now') {
                // alert("kjsakjd")
                buyNow(data);
            }
        @endauth

        @guest
        Swal.fire({
            title: "Bạn cần đăng nhập để thực hiện thao tác này!",
            icon: "warning",
            confirmButtonText: "Đăng nhập",
            showCancelButton: true,
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('auth.login-view') }}";
            }
        });
        @endguest
        }

        function buyNow(data) {
            $.ajax({
                type: "POST",
                url: '{{ route('api.buy-now') }}',
                data: data,
                success: function(response) {
                    console.log(response);
                    const productJson = JSON.stringify(data);
                    localStorage.setItem('productBuyNow', productJson)
                    window.location.href = response.url

                },
                error: function(error) {
                    Swal.fire("Có lỗi xảy ra, vui lòng thử lại sau!", "", "error");
                    console.error(error);
                }
            });
        }


        function sendToCart(data) {
            $.ajax({

                type: "POST",
                url: '{{ route('api.add-cart') }}',
                data: data,
                success: function(response) {
                    let numberCart = response.message.numberCart;
                    document.querySelector("#numberCart").innerText = numberCart;
                    Swal.fire("Thêm vào giỏ hàng thành công!", "", "success");
                },
                error: function(error) {
                    Swal.fire(error.responseJSON.message, "", "error");
                    console.error(error.responseJSON.message);
                }
            });
        }
        $(document).ready(function() {
        $(document).on('click', '.wishlist-icon', function(e) {
                e.preventDefault();
                var productId = $(this).data('id');
                var icon = $(this).find('i');
                var textElement = $(this).siblings('.wishlist-text');

                @auth
                $.ajax({
                    url: '{{ route('toggle.favorite') }}',
                    method: 'POST',
                    data: {
                        userId: {{ Auth::id() }},
                        product_id: productId
                    },
                    success: function(response) {
                        console.log("Love status:", response);
                        $('#love').text(response.love);

                        // Cập nhật trạng thái hiển thị icon và văn bản
                        if (response.status === 'added') {
                            icon.eq(0).hide(); // Ẩn trái tim chưa yêu thích
                            icon.eq(1).show(); // Hiển thị trái tim đã yêu thích
                            textElement.text('Bỏ yêu thích');
                        } else {
                            icon.eq(1).hide(); // Ẩn trái tim đã yêu thích
                            icon.eq(0).show(); // Hiển thị trái tim chưa yêu thích
                            textElement.text('Yêu thích sản phẩm');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Có lỗi xảy ra!", "", "error");
                        console.error(error);
                    }
                });
            @endauth

            @guest Swal.fire({
                title: "Bạn cần đăng nhập để thực hiện thao tác này!",
                icon: "warning",
                confirmButtonText: "Đăng nhập",
                showCancelButton: true,
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('auth.login-view') }}";
                }
            });
        @endguest
        });
        });
    </script>
@endpush
