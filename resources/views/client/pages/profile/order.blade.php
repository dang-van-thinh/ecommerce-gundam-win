@extends('client.pages.profile.layouts.master')

@section('title')
    Lịch sử mua hàng
@endsection

@section('profile')
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
                                    $tabs = [
                                        'PROCESSING' => 'Chờ thanh toán',
                                        'PENDING' => 'Đang chờ xử lý',
                                        'DELIVERING' => 'Đang giao hàng',
                                        'SHIPPED' => 'Đã giao hàng',
                                        'COMPLETED' => 'Thành công',
                                        'CANCELED' => 'Hủy đơn hàng',
                                    ];
                                @endphp
                                @foreach ($tabs as $status => $tabName)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                            id="{{ $status }}-tab" data-bs-toggle="tab"
                                            data-bs-target="#{{ $status }}-tab-pane" role="tab"
                                            aria-controls="{{ $status }}-tab-pane"
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $tabName }}
                                        </button>
                                    </li>
                                @endforeach
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="Description-tab" data-bs-toggle="tab"
                                        data-bs-target="#Description-tab-pane" role="tab"
                                        aria-controls="Description-tab-pane" aria-selected="false">Hoàn hàng</button>
                                </li>
                            </ul>

                            <div class="tab-content product-content" id="ProductContent">
                                @foreach ($tabs as $status => $tabName)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                        id="{{ $status }}-tab-pane" role="tabpanel"
                                        aria-labelledby="{{ $status }}-tab" tabindex="0">
                                        <div class="row gy-4">
                                            @foreach ($orders as $order)
                                                @if ($order->status === $status)
                                                    <!-- Kiểm tra trạng thái đơn hàng -->
                                                    <div class="col-12">
                                                        <div class="order-box">
                                                            <div class="order-container">
                                                                <div class="order-icon">
                                                                    <i class="iconsax" data-icon="box"></i>
                                                                    <div class="couplet"><i class="fa-solid fa-check"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="order-detail d-flex flex-wrap">
                                                                    <div class="order-detail-left"
                                                                        style="flex: 1; min-width: 250px; padding-right: 15px;">
                                                                        <h5>{{ $tabName }}</h5>
                                                                        <p>Ngày đặt đơn:
                                                                            {{ date('d/m/Y', strtotime($order->created_at)) }}
                                                                        </p>
                                                                        <p>Người nhận: {{ $order->customer_name }}</p>
                                                                        <p>Số điện thoại: {{ $order->phone }}</p>
                                                                    </div>
                                                                    <div class="order-detail-right"
                                                                        style="flex: 1; min-width: 250px;">
                                                                        <p>Địa chỉ giao hàng: {{ $order->full_address }}
                                                                        </p>
                                                                        <p>Mã đơn hàng: <span>{{ $order->code }}</span>
                                                                        </p>
                                                                        <p>Ghi chú đơn hàng: {{ $order->note }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="product-order-detail">
                                                                @foreach ($order->orderItems as $orderItem)
                                                                    <div class="product-box mb-3">
                                                                        <a
                                                                            href="{{ route('product', $orderItem->productVariant->product->id) }}">
                                                                            <img src="{{ '/storage/' . $orderItem->productVariant->product->image }}"
                                                                                style="object-fit: cover;"
                                                                                alt="{{ $orderItem->productVariant->product->name }}">
                                                                        </a>
                                                                        <div class="order-wrap">
                                                                            <h5>{{ $orderItem->product_name }}</h5>
                                                                            <ul>
                                                                                <li>
                                                                                    <p>Giá:</p>
                                                                                    <span>{{ number_format($orderItem->product_price) }}
                                                                                        VND</span>
                                                                                </li>
                                                                                <li>
                                                                                    <p>Số lượng:</p>
                                                                                    <span>{{ $orderItem->quantity }}</span>
                                                                                </li>
                                                                                <li>
                                                                                    <p>Biến thể:</p>
                                                                                    <span>{{ $orderItem->productVariant->attributeValues->pluck('name')->implode(' - ') }}</span>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                @php
                                                                    $day = \Carbon\Carbon::parse(
                                                                        $order->updated_at,
                                                                    )->gt(\Carbon\Carbon::now()->subDays(7));
                                                                    $hasRefund = \App\Models\Refund::where(
                                                                        'order_id',
                                                                        $order->id,
                                                                    )->exists();
                                                                @endphp
                                                                @if ($order->status === 'COMPLETED' && $day && !$hasRefund)
                                                                    <div class="mt-3 text-end">
                                                                        <a href="{{ route('profile.order.create.refunds', $order->id) }}"
                                                                            class="btn btn_black sm logout-btn"
                                                                            style="font-size: 14px;">Hoàn
                                                                            hàng</a>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="mt-3 text-center">
                                                                <a style="background-color: #c28f51; border:none;"
                                                                    href="{{ route('profile.order.details', $order->id) }}"
                                                                    class="btn btn-primary">Xem chi tiết đơn hàng</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Tab Hoàn hàng -->
                                <div class="tab-pane fade" id="Description-tab-pane" role="tabpanel"
                                    aria-labelledby="Description-tab" tabindex="0">
                                    <div class="row gy-4">
                                        @foreach ($orders as $order)
                                            @foreach ($order->refund as $refund)
                                                @php
                                                    $refundItemStatus = [
                                                        'PENDING' => ' Đang chờ phê duyệt',
                                                        'APPROVED' => ' Đã được phê duyệt',
                                                        'REJECTED' => 'Bị từ chối',
                                                    ];
                                                    $refundItemReason = [
                                                        'NOT_RECEIVED' => 'Chưa nhận được hàng',
                                                        'MISSING_ITEMS' => 'Thiếu sản phẩm',
                                                        'DAMAGED_ITEMS' => 'Sản phẩm bị hư hỏng',
                                                        'INCORRECT_ITEMS' => 'Sản phẩm không đúng',
                                                        'FAULTY_ITEMS' => 'Sản phẩm bị lỗi',
                                                        'DIFFERENT_FROM_DESCRIPTION' => 'Sản phẩm khác mô tả',
                                                        'USED_ITEMS' => 'Sản phẩm đã qua sử dụng',
                                                    ];

                                                    $refundStatuses = [
                                                        'PENDING' => 'đang chờ phê duyệt',
                                                        'APPROVED' => 'đã được phê duyệt',
                                                        'IN_TRANSIT' => 'đã chuyển cho đơn vị vận chuyển',
                                                        'COMPLETED' => 'Hoàn tiền đã hoàn tất',
                                                    ];
                                                    $statusMessage =
                                                        $refundStatuses[$refund->status] ?? 'Trạng thái không xác định';

                                                @endphp
                                                @if ($order->refund->count() > 0)
                                                    <!-- Kiểm tra nếu đơn hàng có hoàn hàng -->
                                                    <div class="col-12">
                                                        <div class="order-box">
                                                            <div class="order-container">
                                                                <div class="order-icon">
                                                                    <i class="iconsax" data-icon="box"></i>
                                                                    <div class="couplet"><i class="fa-solid fa-check"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="order-detail d-flex flex-wrap">
                                                                    <div class="order-detail-left"
                                                                        style="flex: 1; min-width: 250px; padding-right: 15px;">
                                                                        <h5>Hoàn hàng( {{ $statusMessage }} )</h5>
                                                                        <p>Ngày đặt đơn:
                                                                            {{ date('d/m/Y', strtotime($order->created_at)) }}
                                                                        </p>
                                                                        <p>Người nhận: {{ $order->customer_name }}</p>
                                                                        <p>Số điện thoại: {{ $order->phone }}</p>
                                                                    </div>
                                                                    <div class="order-detail-right"
                                                                        style="flex: 1; min-width: 250px;">
                                                                        <p>Địa chỉ giao hàng:
                                                                            {{ $order->full_address }}
                                                                        </p>
                                                                        <p>Mã đơn hàng:
                                                                            <span>{{ $order->code }}</span>
                                                                        </p>
                                                                        <p>Ghi chú đơn hàng: {{ $order->note }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="product-order-detail">
                                                                <h5 class="mb-1">Chi tiêt đơn hoàn :</h5>
                                                                <div class="product-box flex-column">
                                                                    @foreach ($refund->refundItem as $item)
                                                                        <div class="refund-item">
                                                                            <!-- Tên sản phẩm và biến thể -->
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center mb-2">
                                                                                <p>
                                                                                    Sản phẩm hoàn trả :
                                                                                    {{ $item->productVariant->product->name }}
                                                                                    ({{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                                                                                </p>
                                                                            </div>

                                                                            <!-- Số lượng hoàn trả -->
                                                                            <div class="mb-2">
                                                                                <p>
                                                                                    Số lượng hoàn:
                                                                                    {{ $item->quantity }}
                                                                                </p>

                                                                            </div>

                                                                            <!-- Lý do hoàn trả -->
                                                                            <div class="mb-2">
                                                                                <p>
                                                                                    Lý do:
                                                                                    {{ $refundItemReason[$item->reason] }}
                                                                                </p>
                                                                            </div>

                                                                            <!-- Mô tả chi tiết -->
                                                                            <div class="mb-2">
                                                                                <p>
                                                                                    Mô tả chi tiết:
                                                                                    {{ $item->description }}
                                                                                </p>

                                                                            </div>

                                                                            <!-- Hình ảnh sản phẩm hoàn trả -->
                                                                            <div class="d-flex mb-2">
                                                                                <div>
                                                                                    <p>Hình ảnh:</p>
                                                                                </div>
                                                                                <div class="ms-2">
                                                                                    <img src="{{ '/storage/' . $item->img }}"
                                                                                        alt="Hình ảnh sản phẩm"
                                                                                        width="100" height="120">
                                                                                </div>
                                                                            </div>

                                                                            <!-- Trạng thái hoàn trả -->
                                                                            <div class="mb-2">
                                                                                <strong>Trạng thái:</strong>
                                                                                {{ $refundItemStatus[$item->status] }}
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
