@extends('client.pages.profile.layouts.master')

@section('title')
Chi tiết đơn hàng
@endsection

@section('profile')
<style>
    .rating {
        list-style: none;
        padding: 0;
        display: flex;
        align-items: center; /* Căn giữa các sao với số lượng */
    }

    .rating li {
        margin-right: 5px;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 24px;
        color: #ddd;
        cursor: pointer;
    }

    .rating input:checked + label,
    .rating input:checked ~ label {
        color: #f39c12;
    }

    .rating span {
        font-size: 16px; /* Cỡ chữ cho số sao */
        margin-left: 10px; /* Khoảng cách giữa sao và số lượng */
    }
</style>
<div class="dashboard-right-box">
    <div class="order">
        <div class="sidebar-title">
            <div class="loader-line"></div>
            <h4>Chi tiết đơn hàng</h4>
        </div>
        <div class="row gy-4">
            <div class="col-12">
                <div class="order-box">
                    <div class="order-container">
                        <div class="order-icon">
                            <i class="iconsax" data-icon="box"></i>
                            <div class="couplet">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>
                        <div class="order-detail">
                            <h5>Trạng thái: {{ $order->status }}</h5>
                            <p>Ngày giao: {{ date('D, d M', strtotime($order->delivery_date)) }}</p>
                        </div>
                    </div>
                    <div class="product-order-detail">
                    @foreach ($order->orderItems as $item)
                        <div class="product-box">
                            <a href="{{ route('product', $item->productVariant->product->id) }}">
                                <img src="{{ '/storage/' . $item->productVariant->product->image }}" alt="{{ $item->productVariant->product->name }}" />
                            </a>
                            <div class="order-wrap">
                                <h5>{{ $item->product_name }}</h5>
                                <p>{{ $order->note }}</p>
                                <ul>
                                    <li>
                                        <p>Giá:</p>
                                        <span>{{ number_format($item->product_price) }} Vnd</span>
                                    </li>
                                    <li>
                                        <p>Số lượng:</p>
                                        <span>{{ $item->quantity }}</span>
                                    </li>
                                    <li>
                                        <p>Biến thể:</p>
                                        <span>{{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}</span>
                                    </li>
                                    <li>
                                        <p>Mã đơn hàng:</p>
                                        <span>{{ $order->id }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="return-box">
    <div class="review-box">
    <ul class="rating">
            @php
                $rating = $item->feedback ? $item->feedback->rating : 0; // Lấy rating từ feedback
            @endphp
            @for ($i = 1; $i <= 5; $i++)
                <li>
                    <i class="fa-solid fa-star" style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                </li>
            @endfor
            <span>{{ number_format($rating, 1) }} / 5 sao</span> <!-- Hiển thị số sao trung bình -->
        </ul>



        @if ($item->feedback)
            @php
                // Kiểm tra xem đã hơn 3 ngày kể từ khi đánh giá được tạo không
                $threeDaysAgo = now()->subDays(3);
                $canEditReview = $item->feedback->updated_at === null || $item->feedback->created_at > $threeDaysAgo;
            @endphp

            @if ($canEditReview)
                <span data-bs-toggle="modal" data-bs-target="#EditReview-modal" data-feedback="{{ $item->feedback->id }}" title="Quick View" tabindex="0">Sửa đánh giá</span>
                @include('client.pages.profile.layouts.components.edit-rating-product')
            @else
                <span>Cảm ơn bạn đã mua sản phẩm của chúng tôi</span>
            @endif
        @else
            <span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Viết đánh giá</span>
            @include('client.pages.profile.layouts.components.rating-product')
        @endif
    </div>
</div>

                    @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a style="background-color: #c28f51; border:none;" href="{{ route('profile.order-history') }}" class="btn btn-primary">Lịch sử đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
