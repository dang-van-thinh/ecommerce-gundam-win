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
        align-items: center;
        /* Căn giữa các sao với số lượng */
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

    .rating input:checked+label,
    .rating input:checked~label {
        color: #f39c12;
    }

    .rating span {
        font-size: 16px;
        /* Cỡ chữ cho số sao */
        margin-left: 10px;
        /* Khoảng cách giữa sao và số lượng */
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
                            @php
                                // Danh sách các trạng thái và tên tab tương ứng
                                $tabs = [
                                    'PROCESSING' => 'Chờ thanh toán',
                                    'PENDING' => 'Đang chờ xử lý',
                                    'DELIVERING' => 'Đang giao hàng',
                                    'SHIPPED' => 'Đã giao hàng',
                                    'COMPLETED' => 'Thành công',
                                    'CANCELED' => 'Hủy đơn hàng',
                                ];
                                $statusText = $tabs[$order->status] ?? 'Không xác định';
                            @endphp
                            <div class="order-detail d-flex flex-wrap">
                                <div class="order-detail-left" style="flex: 1; min-width: 250px; padding-right: 15px;">
                                    <h4>{{$statusText}}</h4>
                                    <p>Ngày đặt đơn:
                                        {{ date('d/m/Y', strtotime($order->created_at)) }}
                                    </p>
                                    <p>Người nhận: {{ $order->customer_name }}</p>
                                    <p>Số điện thoại: {{ $order->phone }}</p>
                                </div>
                                <div class="order-detail-right" style="flex: 1; min-width: 250px;">
                                    <p>Địa chỉ giao hàng: {{ $order->full_address }}
                                    </p>
                                    <p>Mã đơn hàng: <span>{{ $order->code }}</span>
                                    </p>
                                    <p>Ghi chú đơn hàng: {{ $order->note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-order-detail">
                        @foreach ($order->orderItems as $item)
                                            <div class="product-box">
                                                <a href="{{ route('product', $item->productVariant->product->id) }}">
                                                    <img src="{{ '/storage/' . $item->productVariant->product->image }}"
                                                        alt="{{ $item->productVariant->product->name }}" />
                                                </a>
                                                <div class="order-wrap">
                                                    <h5>{{ $item->product_name }}</h5>
                                                    <p>{{ $order->note }}</p>
                                                    <ul>
                                                        <li>
                                                            <p>Giá:</p>
                                                            <span>{{ number_format($item->product_price) }} VND</span>
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
                                                            <span>{{ $order->code }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="return-box">
                                                <div class="review-box">
                                                    <ul class="rating">
                                                        @if ($order->status === 'COMPLETED' && $order->confirm_status === 'ACTIVE')
                                                                                        @php
                                                                                            $rating = $item->feedback ? $item->feedback->rating : 0; // Lấy rating từ feedback
                                                                                        @endphp
                                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                                            <li>
                                                                                                <i class="fa-solid fa-star"
                                                                                                    style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                                                                            </li>
                                                                                        @endfor
                                                                                        <span>{{ number_format($rating, 1) }} / 5 sao</span>
                                                                                        <!-- Hiển thị số sao trung bình -->
                                                        @endif
                                                    </ul>
                                                    @if ($order->status === 'COMPLETED' && $order->confirm_status === 'ACTIVE')
                                                        @if ($item->feedback)
                                                            <span>Cảm ơn bạn đã mua sản phẩm của chúng tôi</span>
                                                        @else
                                                            <span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Đánh giá"
                                                                tabindex="0">Viết đánh giá</span>
                                                            @include('client.pages.profile.layouts.components.rating-product')
                                                        @endif
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                        @endforeach
                        @if ($order->confirm_status === 'IN_ACTIVE' && $order->status === 'SHIPPED')
                            <div class="mt-3 text-center">
                                <form action="{{ route('profile.order.confirmstatus', $order->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button style="background-color: #c28f51; border:none;" type="submit"
                                        class="btn btn-danger">Đã nhận hàng
                                    </button>
                                </form>
                            </div>
                        @endif


                    </div>
                    <div class="mt-3" style="bottom: 0; right: 0; text-align: right; margin-right:20px;">
                        <div class="order-summary">
                            <h4>Tổng đơn hàng:</h4>
                            <p><strong>{{ number_format($totalPrice) }} VND</strong></p>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <a style="background-color: #c28f51; border:none;" href="{{ route('profile.order-history') }}"
                            class="btn btn-primary">Lịch sử đơn hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

