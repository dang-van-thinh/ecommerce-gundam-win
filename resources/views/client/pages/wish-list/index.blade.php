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
    ])
    <section class="section-b-space pt-0">
        <div class="custom-container wishlist-box container">
            <div class="product-tab-content ratio1_3">
                <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                    @foreach ($favorites as $favorite)
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block">
                                        <a class="label-2 wishlist-icon delete-button" title="Remove from Wishlist"
                                            tabindex="0" data-id="{{ $favorite->id }}">
                                            <i class="iconsax" data-icon="trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="product-image">
                                        <a class="pro-first" href="{{ route('product', $favorite->product_id) }}">
                                            <img class="bg-img" src="{{ asset('storage/' . $favorite->product->image) }}"
                                                alt="product">
                                        </a>
                                        @php
                                            $firstImage = $favorite->product->productImages->first();
                                        @endphp
                                        <a class="pro-sec" href="{{ route('product', $favorite->product_id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                alt="product" />
                                        </a>
                                        @if ($favorite->product->status === 'IN_ACTIVE')
                                            <!-- Lớp phủ cho sản phẩm hết hàng -->
                                            <div
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                                                    background-color: rgba(0, 0, 0, 0.6); display: flex; 
                                                    justify-content: center; align-items: center; color: #fff; 
                                                    font-size: 25px; font-weight: bold; z-index: 5;">
                                                NGƯNG BÁN
                                            </div>
                                        @elseif ($favorite->product->is_out_of_stock)
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
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <ul class="rating">
                                            @php
                                                $rating = $favorite->product->average_rating
                                                    ? ceil($favorite->product->average_rating)
                                                    : 0; // Lấy rating từ feedback
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <i class="fa-solid fa-star"
                                                        style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                                </li>
                                            @endfor
                                        </ul>
                                    </ul>
                                    <a href="{{ route('product', $favorite->product->id) }}">
                                        <h6>{{ $favorite->product->name }}</h6>
                                    </a>
                                    <p class="list-per">{{ $favorite->product->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.wishlist-icon', function(e) {
                var favoriteId = $(this).data('id');
                var row = $(this).closest('.col'); // Lấy phần tử chứa sản phẩm yêu thích

                $.ajax({
                    url: '{{ url('api/remove-favorite') }}', // Gọi đúng route API
                    method: 'DElETE',
                    data: {
                        userId: @php
                            echo Auth::id();
                        @endphp,
                        favorite_id: favoriteId
                    },
                    success: function(response) {
                        if (response.status === 'removed') {
                            row.fadeOut(); // Xóa sản phẩm khỏi danh sách yêu thích
                            document.querySelector('#love').innerText = response.love
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Có lỗi xảy ra!');
                    }
                });
            });
        });
    </script>
@endpush
