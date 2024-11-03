@extends('client.pages.profile.layouts.master')

@section('title')
Lịch sử mua hàng
@endsection

@section('profile')
<style>
    .rating {
        list-style: none;
        padding: 0;
        display: flex;
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

    .rating input:checked + label {
        color: #f39c12;
    }

    .rating input:checked ~ label {
        color: #f39c12;
    }
</style>

<div class="dashboard-right-box">
    <div class="order">
        <div class="sidebar-title">
            <div class="product-section-box x-small-section pt-0">
                <div class="custom-container container">
                    <div class="row">
                        <div class="loader-line"></div>
                        <h4>Lịch sử đơn hàng</h4>
                    </div>
                    <div class="col-12">
                        <ul class="product-tab theme-scrollbar nav nav-tabs nav-underline" id="Product" role="tablist">
                            @php
                                // Danh sách các trạng thái và tên tab tương ứng
                                $tabs = [
                                    'COMPLETED' => 'Thành công',
                                    'PENDING' => 'Đang chờ xử lý',
                                    'DELIVERING' => 'Đang giao hàng',
                                    'SHIPPED' => 'Đã vận chuyển',
                                    'CANCELED' => 'Hủy đơn hàng'
                                ];
                            @endphp
                            @foreach ($tabs as $status => $tabName)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $status }}-tab"
                                        data-bs-toggle="tab" data-bs-target="#{{ $status }}-tab-pane" role="tab"
                                        aria-controls="{{ $status }}-tab-pane"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $tabName }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content product-content" id="ProductContent">
                            @foreach ($tabs as $status => $tabName)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ $status }}-tab-pane" role="tabpanel" aria-labelledby="{{ $status }}-tab"
                                    tabindex="0">
                                    <div class="row gy-4">
                                        @foreach ($history as $item)
                                            @if ($item->order->status === $status)
                                                <div class="col-12">
                                                    <div class="order-box">
                                                        <div class="order-container">
                                                            <div class="order-icon">
                                                                <i class="iconsax" data-icon="box"></i>
                                                                <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                            </div>
                                                            <div class="order-detail">
                                                                <h5>{{ $tabName }}</h5>
                                                                <p>Ngày {{ date('d/m/Y', strtotime($item->order->created_at)) }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="product-order-detail">
                                                            <div class="product-box">
                                                                <a href="{{ route('product', $item->productVariant->product->id) }}">
                                                                    <img src="{{ '/storage/' . $item->productVariant->product->image }}"
                                                                        style="object-fit: cover;"
                                                                        alt="{{ $item->productVariant->product->image }}">
                                                                </a>
                                                                <div class="order-wrap">
                                                                    <h5>{{ $item->product_name }}</h5>
                                                                    <p>{{ $item->order->note }}</p>
                                                                    <ul>
                                                                        <li>
                                                                            <p>Giá:</p><span>{{ $item->product_price }} Vnd</span>
                                                                        </li>
                                                                        <li>
                                                                            <p>Số lượng:</p><span>{{ $item->quantity }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <p>Biến thể:</p>
                                                                            <span>{{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <p>Mã đơn hàng:</p>
                                                                            <span>{{ $item->order->id }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="return-box">
    @if($item->order->status === 'COMPLETED')
        @php
            // Lấy tất cả phản hồi của người dùng theo ID đơn hàng
            $userFeedbacks = $item->order->feedbacks()->where('user_id', auth()->id())->get();
            $daysSinceLastFeedbackCreated = $userFeedbacks->isNotEmpty() ? now()->diffInDays($userFeedbacks->last()->created_at) : null;
        @endphp

        <div class="review-box">
            @if($userFeedbacks->isNotEmpty())
                @foreach ($userFeedbacks as $userFeedback)
                    <ul class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $userFeedback->rating)
                                <li><i class="fa-solid fa-star"></i></li>
                            @else
                                <li><i class="fa-regular fa-star"></i></li>
                            @endif
                        @endfor
                    </ul>
                    <p>{{ $userFeedback->comment }}</p>

                    @if($userFeedback->has_edited === 0)
                        <span data-bs-toggle="modal" data-bs-target="#Reviews-modal"
                              title="Đánh giá sản phẩm" tabindex="0">
                            Đánh giá sản phẩm
                        </span>
                        @include('client.pages.profile.layouts.components.rating-product')
                    @elseif($userFeedback->has_edited === 1 && $daysSinceLastFeedbackCreated <= 3)
                        <span data-bs-toggle="modal" data-bs-target="#EditReview-modal"
                              title="Chỉnh sửa đánh giá lần cuối" tabindex="0">
                            Chỉnh sửa đánh giá lần cuối
                        </span>
                        @include('client.pages.profile.layouts.components.edit-rating-product')
                    @elseif($userFeedback->has_edited > 1)
                        <p>Bạn không thể chỉnh sửa hoặc đánh giá lại nữa.</p>
                    @endif
                @endforeach
            @else
                @if(now()->diffInDays($item->order->created_at) > 3)
                    <p>Bạn không thể đánh giá sản phẩm cho đơn hàng này nữa.</p>
                @else
                    <ul class="rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <li><i class="fa-regular fa-star"></i></li>
                        @endfor
                    </ul>
                    <span data-bs-toggle="modal" data-bs-target="#Reviews-modal"
                          title="Đánh giá sản phẩm" tabindex="0">
                        Đánh giá sản phẩm
                    </span>
                    @include('client.pages.profile.layouts.components.rating-product')
                @endif
            @endif
        </div>
    @endif
    <h6>
        <span></span>
        Đổi trả trong vòng 3 ngày kể từ
        {{ date('d/m', strtotime($item->order->updated_at)) }}
    </h6>
</div>

                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
