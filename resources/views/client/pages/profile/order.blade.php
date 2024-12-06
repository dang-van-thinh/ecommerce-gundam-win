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
                                                                        <h4>{{ $tabName }}</h4>
                                                                        <p>Ngày đặt đơn:
                                                                            {{ date('d/m/Y', strtotime($order->created_at)) }}
                                                                        </p>
                                                                        <p>Người nhận: {{ $order->customer_name }}</p>
                                                                        <p>Số điện thoại: {{ $order->phone }}</p>
                                                                    </div>
                                                                    <div class="order-detail-right"
                                                                        style="flex: 1; min-width: 250px;">
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
                                                                                        <!-- Nút hủy đơn hàng -->
                        @if ($order->status === 'PENDING')
                            <div class="position-relative">
                                <div class="mt-3" style="position: absolute; bottom: 20px; right: 20px;">
                                    <!-- Nút hủy đơn hàng -->
                                    <button style="background-color: #c28f51; border:none;" type="button"
                                        class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#CancelOrderModal">Hủy
                                        đơn hàng
                                    </button>
                                </div>
                            </div>
                            <!-- Modal xác nhận hủy đơn hàng -->
                            <div class="modal fade" id="CancelOrderModal" tabindex="-1"
                                aria-labelledby="CancelOrderModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="CancelOrderModalLabel">Xác nhận hủy đơn hàng
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn hủy đơn hàng này? Lý do hủy:
                                            <!-- Form nhập lý do hủy -->
                                            <form action="{{ route('profile.order.cancel', $order->id) }}" method="POST"
                                                id="cancelOrderForm">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group mt-3">
                                                    <label for="cancel_reason">Chọn lý do hủy đơn hàng:</label><br>
                                                    <input type="radio" name="cancel_reason" id="wrong_product"
                                                        value="wrong_product">
                                                    <label for="wrong_product">Sản phẩm sai</label><br>

                                                    <input type="radio" name="cancel_reason" id="change_of_mind"
                                                        value="change_of_mind">
                                                    <label for="change_of_mind">Thay đổi ý định</label><br>

                                                    <input type="radio" name="cancel_reason" id="price_too_high"
                                                        value="price_too_high">
                                                    <label for="price_too_high">Giá quá cao</label><br>

                                                    <input type="radio" name="cancel_reason" id="payment_issue"
                                                        value="payment_issue">
                                                    <label for="payment_issue">Vấn đề thanh toán</label><br>

                                                    <input type="radio" name="cancel_reason" id="long_wait_time"
                                                        value="long_wait_time">
                                                    <label for="long_wait_time">Chờ lâu</label><br>

                                                    <input type="radio" name="cancel_reason" id="other" value="other">
                                                    <label for="other">Khác</label>
                                                </div>

                                                <div class="form-group mt-3" id="other_reason_box" style="display: none;">
                                                    <label for="cancel_reason_other">Lý do khác:</label>
                                                    <input type="text" name="cancel_reason_other" id="cancel_reason_other"
                                                        class="form-control" />
                                                    @error('cancel_reason_other')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng
                                                    </button>
                                                    <button type="submit" class="btn btn-danger">Xác nhận
                                                        hủy
                                                    </button>
                                                </div>
                                            </form>

                                            @error('cancel_reason')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Script để hiển thị ô nhập lý do khi chọn "Khác" -->
                            <script>
                                document.querySelectorAll('input[name="cancel_reason"]').forEach(function (radio) {
                                    radio.addEventListener('change', function () {
                                        var otherReasonBox = document.getElementById('other_reason_box');
                                        var cancelReasonOtherInput = document.getElementById('cancel_reason_other');

                                        if (this.value === 'other') {
                                            otherReasonBox.style.display = 'block'; // Hiển thị ô nhập lý do khác
                                        } else {
                                            otherReasonBox.style.display = 'none'; // Ẩn ô nhập lý do khác
                                            cancelReasonOtherInput.value = ''; // Xóa nội dung đã nhập trong ô "Khác"
                                        }
                                    });
                                });
                            </script>
                        @endif
                                                            </div>
                                                            @if ($order->confirm_status === 'IN_ACTIVE' && $order->status === 'PROCESSING')
                            <div class="mt-3 text-center">
                                <button style="background-color: #c28f51; border:none;" type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#CancelOrderModal">Xóa
                                    đơn hàng
                                </button>
                                <button style="background-color: #c28f51; border:none;" type="button" id="checkout-continue"
                                    data-order="{{ $order->id }}" class="btn btn-danger">
                                    Tiếp
                                    tục thanh toán
                                </button>
                            </div>
                            <!-- Modal xác nhận xóa đơn hàng -->
                            <div class="modal fade" id="CancelOrderModal" tabindex="-1"
                                aria-labelledby="CancelOrderModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="CancelOrderModalLabel">Xác nhận xóa đơn hàng
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa đơn hàng này?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng
                                            </button>
                                            <form action="{{ route('profile.order.delete', $order->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let btnCheckOutContinue = document.getElementById("checkout-continue");
            btnCheckOutContinue.addEventListener("click", (e) => {
                // alert("sdakdas")
                // debug;
                console.log(btnCheckOutContinue.getAttribute("data-order"))
                let orderId = btnCheckOutContinue.getAttribute("data-order");
                $.ajax({
                    url: "/api/check-out/continue",
                    type: 'POST',
                    data: {
                        orderId: orderId
                    },
                    success: function (response) {
                        // console.log(response);
                        window.location.href = response.urlRedirect
                    },

                });

            })
        })
    </script>
@endpush
