@extends('client.layouts.master')
@section('title')
    Thanh toán đơn hàng
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Thanh toán đơn hàng',
        'parent' => [
            'route' => '',
            'name' => 'Giỏ hàng',
        ],
    ])
    <section class="section-b-space pt-0">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('place-order') }}" method="POST">
            @csrf
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xxl-9 col-lg-8">
                        <div class="left-sidebar-checkout sticky">
                            <div class="address-option">
                                <div class="address-title">
                                    <h4>Địa Chỉ Giao Hàng </h4><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#add-address-modal" title="Quick View" tabindex="0">+ Thêm Mới Địa
                                        Chỉ</a>
                                </div>
                                <div class="row">
                                    {{-- @dd($userAddress) --}}
                                    @foreach ($userAddress as $key => $item)
                                        <div class="col-xxl-4">
                                            {{-- @dd($item->toArray())    --}}
                                            <label for="{{ $key }}">
                                                <span class="delivery-address-box">
                                                    <span class="form-check">
                                                        <input class="custom-radio" value="{{ $item['id'] }}"
                                                            data-value="{{ $key }}" id="{{ $key }}"
                                                            type="radio"
                                                            @if ($item['default'] == 1) checked="checked" @endif
                                                            name="address_user_id"
                                                            onclick="setDefaultAddress({{ $item->id }}, {{ $item->user_id }})">
                                                    </span>
                                                    <span class="address-detail">

                                                        <span class="address">
                                                            <span class="address-title"> Địa chỉ {{ $key + 1 }}</span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag"> Địa chỉ:</span>
                                                                <input type="hidden" name="address_user"
                                                                    value="{{ $item['id'] }}">
                                                                {{ $item->address_detail }},
                                                                {{ $item->ward->name }},
                                                                {{ $item->district->name }},
                                                                {{ $item->province->name }}
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Người nhận:</span>
                                                                {{ $item->name }}
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Sđt:</span>
                                                                {{ $item->phone }}
                                                            </span>
                                                        </span>

                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="payment-options">
                                <h4 class="mb-3">Phương Thức Thanh Toán</h4>
                                <div class="row gy-3">
                                    <div class="col-sm-6">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="cod" type="radio" checked="checked"
                                                value="cod" name="payment_method">
                                            <label for="cod">Thanh toán khi nhận hàng</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="momo" type="radio"
                                                name="payment_method" value="momo">
                                            <label for="momo">Thanh toán qua MOMO</label>

                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="vnpay" type="radio"
                                                name="payment_method" value="vnpay">
                                            <label for="vnpay">Thanh toán qua VNPAY</label>

                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="address-option">
                                <textarea name="note" class="form-control" id="" placeholder="Ghi chú đơn hàng" cols="30"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4">
                        <div class="right-sidebar-checkout">
                            <h4>Thanh Toán</h4>
                            <div class="cart-listing">
                                <ul>
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    {{-- @dd($productResponse) --}}
                                    @foreach ($productResponse as $key => $item)
                                    {{-- @dd($item['cart']) --}}
                                    <input type="hidden" name="carts_selected[]" value="{{$item['cart']['id']}}">
                                        @php
                                            $totalAmount +=
                                                $item['product_variant']['price'] * $item['cart']['quantity'];
                                        @endphp
                                        <li>
                                            <img width="60px" src="{{ '/storage/' . $item['product']['image'] }}"
                                                alt="">
                                            <div>
                                                <h6>{{ $item['product']['name'] }}</h6>
                                                @foreach ($item['product_variant']['attribute_values'] as $variant)
                                                    <p>{{ $variant['attribute']['name'] }}: <span>
                                                            {{ $variant['name'] }} </span></p>
                                                @endforeach
                                                <!-- hien thi so luong-->
                                                <p class="fs-6">
                                                    Số lượng: {{ $item['cart']['quantity'] }}
                                                </p>
                                            </div>
                                            <div>

                                            </div>
                                            <p class="">
                                                {{ number_format($item['product_variant']['price'] * $item['cart']['quantity'], 0, ',', '.') }}
                                                VND</p>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="coupon-box">
                                    <h6>Mã giảm giá</h6>

                                    <div id="coupon-display" style="display: none;" class="mb-2">
                                        <!-- Thẻ hiển thị mã giảm giá -->
                                        <div
                                            class="border-success bg-light d-flex justify-content-between align-items-center rounded border p-2 shadow-sm">
                                            <div>
                                                <strong id="coupon-name" class="text-dark">Tên mã ở đây</strong>
                                            </div>
                                            <button id="remove-coupon" class="btn btn-danger btn-sm"
                                                style="font-size: 14px;">X</button>
                                        </div>
                                    </div>


                                    <ul>
                                        <li class="d-flex justify-content-end">
                                            <a data-bs-toggle="modal" data-bs-target="#voucherModal">Kho ưu đãi >></a>
                                        </li>

                                        <li>
                                            <span>
                                                <input type="text" id="voucher-code-input"
                                                    placeholder="Sử dụng mã giảm giá">
                                                <i class="iconsax me-1" data-icon="tag-2"></i>
                                            </span>
                                            <button type="button" style="font-size: 14px; padding: 5px; width: 107px;"
                                                id="apply" class="btn w-50%">
                                                Áp dụng
                                            </button>
                                        </li>
                                    </ul>
                                    <input type="hidden" id="user-id" name="user-id" value="{{ Auth::id() }}">
                                    <!-- Thêm input ẩn để lưu voucher_id -->
                                    <input type="hidden" id="voucher-id-input" name="voucher_id" value="">
                                    <input type="hidden" id="id-input" name="id_voucherUsage" value="">

                                    <!-- Modal -->
                                    <div class="modal fade" id="voucherModal" tabindex="-1"
                                        aria-labelledby="voucherModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <!-- Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="voucherModalLabel">Mã giảm giá</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <!-- Body -->
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            @foreach ($voucher as $item)
                                                                <div class="col-6 mb-3">
                                                                    @php
                                                                        $isInactive =
                                                                            $item->voucher->status === 'IN_ACTIVE' ||
                                                                            strtotime($item->voucher->start_date) >
                                                                                time() ||
                                                                            strtotime($item->voucher->end_date) <
                                                                                time() ||
                                                                            ($item->voucher->limited_uses &&
                                                                                $item->used >=
                                                                                    $item->voucher->limited_uses) ||
                                                                            $item->voucher->limit == 0 ||
                                                                            $totalAmount <
                                                                                $item->voucher->min_order_value ||
                                                                            $totalAmount >
                                                                                $item->voucher->max_order_value;
                                                                    @endphp
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center {{ $isInactive ? 'border-secondary bg-light' : 'border-primary bg-light' }} rounded border p-3 shadow-sm">
                                                                        <div>
                                                                            <strong
                                                                                class="{{ $isInactive ? 'text-muted' : 'text-dark' }}">{{ $item->voucher->name }}</strong>
                                                                            <p class="mb-0">
                                                                                Giảm:
                                                                                @if ($item->voucher->discount_type === 'PERCENTAGE')
                                                                                    {{ number_format($item->voucher->discount_value, 0) }}%
                                                                                @else
                                                                                    {{ number_format($item->voucher->discount_value, 0, ',', '.') }}
                                                                                    VND
                                                                                @endif
                                                                            </p>
                                                                            <p>Hạn đến: {{ $item->voucher->end_date }}</p>
                                                                        </div>
                                                                        <button type="button"
                                                                            class="btn {{ $isInactive ? 'btn-secondary' : 'btn-primary' }} apply-coupon"
                                                                            data-voucher-name="{{ $item->voucher->name }}"
                                                                            data-id="{{ $item->id }}"
                                                                            data-voucher-id="{{ $item->voucher->id }}"
                                                                            data-discount-value="{{ $item->voucher->discount_value }}"
                                                                            data-discount-type="{{ $item->voucher->discount_type }}"
                                                                            data-min-amount="{{ $item->voucher->min_order_value }}"
                                                                            data-max-amount="{{ $item->voucher->max_order_value }}"
                                                                            data-start-date="{{ $item->voucher->start_date }}"
                                                                            data-end-date="{{ $item->voucher->end_date }}"
                                                                            data-status="{{ $item->voucher->status }}"
                                                                            data-limited-uses="{{ $item->voucher->limited_uses }}"
                                                                            data-used="{{ $item->used }}"
                                                                            {{ $isInactive ? 'disabled' : '' }}>
                                                                            Áp dụng
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="summary-total">
                                    <ul>
                                        <li>
                                            <p>Tổng giá</p>
                                            <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
                                            <span>{{ number_format($totalAmount, 0, ',', '.') }} VND</span>
                                        </li>
                                        <li>
                                            <p>Giảm giá</p>
                                            <input type="hidden" name="discount_amount" value="0">
                                            <span id="discount-amount"> 0 VND</span> <!-- Hiển thị với dấu trừ -->
                                        </li>

                                    </ul>

                                </div>
                                <div class="total">
                                    <h6>Thành tiền : </h6>
                                    <h6 id="summary-total">{{ number_format($totalAmount, 0, ',', '.') }} VND</h6>
                                    <input type="hidden" value="{{ $totalAmount }}" name="total_amount">
                                </div>
                                <div class="order-button">
                                    <button type="submit" class="btn btn_black sm w-100 rounded">Đặt hàng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('client.pages.profile.layouts.components.add-address')
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // lay dia chi them moi
        $('#provinceAdd').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                var url = `{{ route('api.districts', ['province_id' => ':province_id']) }}`;
                url = url.replace(':province_id', provinceId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#districtAdd').empty().append(
                            '<option value="">Chọn Huyện/Quận</option>');
                        $('#wardAdd').empty().append(
                            '<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function(key, value) {
                            $('#districtAdd').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        $('#districtAdd').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                var url = `{{ route('api.wards', ['district_id' => ':district_id']) }}`;
                url = url.replace(':district_id', districtId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#wardAdd').empty().append(
                            '<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function(key, value) {
                            $('#wardAdd').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // hien thi voucher sugest
        let voucherSugest = @json($voucherApply);
        // console.log("hiii", voucherSugest);
        if (voucherSugest != null) {
            showBoxVoucherActive(voucherSugest);
        }

        // Lắng nghe sự kiện nhấn nút "Áp dụng" trong modal
        document.querySelectorAll('.apply-coupon').forEach(button => {
            button.addEventListener('click', function() {
                // Lấy các thông tin mã giảm giá từ nút được nhấn
                const voucherName = this.getAttribute('data-voucher-name');
                const Id = this.getAttribute('data-id'); // Lấy voucher_id
                const voucherId = this.getAttribute('data-voucher-id'); // Lấy voucher_id
                const discountValue = parseFloat(this.getAttribute('data-discount-value'));
                const discountType = this.getAttribute('data-discount-type');
                const minAmount = parseFloat(this.getAttribute(
                    'data-min-amount')); // Khoảng giá tối thiểu
                const maxAmount = parseFloat(this.getAttribute(
                    'data-max-amount')); // Khoảng giá tối đa
                // Lấy tổng giá hiện tại
                const totalAmount = parseFloat(document.querySelector(
                    'input[name="totalAmount"]').value);
                const limitedUses = this.getAttribute('data-limited-uses')
                const used = this.getAttribute('data-used')
                const startDate = new Date(this.getAttribute('data-start-date')).getTime();
                const endDate = new Date(this.getAttribute('data-end-date')).getTime();
                const status = this.getAttribute('data-status'); // Lấy giá trị trạng thái
                const now = Date.now(); // Lấy thời gian hiện tại dưới dạng timestamp

                // Kiểm tra điều kiện
                if (startDate > now || endDate < now || status === 'IN_ACTIVE') {
                    alert('Mã giảm giá không khả dụng');
                    return;
                }

                if (limitedUses == used) {
                    alert('Mã giảm giá này đã hết lượt sử dụng');
                    return;
                }

                // Kiểm tra nếu tổng giá nằm ngoài khoảng áp dụng
                if (totalAmount < minAmount || totalAmount > maxAmount) {
                    alert(
                        `Mã giảm giá chỉ áp dụng cho tổng giá từ ${minAmount.toLocaleString()} VND đến ${maxAmount.toLocaleString()} VND.`
                    );
                    return; // Dừng nếu không thỏa mãn điều kiện
                }

                // Hiển thị thẻ mã giảm giá đã áp dụng và ẩn ô input
                document.getElementById('coupon-display').style.display = 'block';
                document.getElementById('coupon-name').textContent = voucherName;

                // Cập nhật voucher_id vào input ẩn
                document.getElementById('voucher-id-input').value =
                    voucherId; // Gán voucher_id vào input ẩn
                document.getElementById('id-input').value = Id; // Gán voucher_id vào input ẩn

                // Tính toán giảm giá
                let discountAmount = 0;
                if (discountType === 'PERCENTAGE') {
                    discountAmount = (discountValue / 100) *
                        totalAmount; // Tính giảm giá theo phần trăm
                } else {
                    discountAmount = discountValue; // Tính giảm giá cố định theo số tiền
                    if (totalAmount <= discountAmount) {
                        discountAmount = totalAmount;
                    }
                }

                const newTotal = totalAmount - discountAmount;

                // Cập nhật giá trị vào giao diện
                document.querySelector('input[name="discount_amount"]').value = discountAmount;
                document.getElementById('discount-amount').textContent =
                    `- ${discountAmount.toLocaleString()} VND`; // Hiển thị giảm giá thực tế

                // Cập nhật tổng tiền
                document.querySelector('input[name="total_amount"]').value = newTotal;
                document.getElementById('summary-total').textContent =
                    `${newTotal.toLocaleString()} VND`;

                // Đóng modal sau khi chọn
                const voucherModalEl = document.getElementById('voucherModal');
                const voucherModal = bootstrap.Modal.getInstance(voucherModalEl);
                voucherModal.hide();
            });
        });

        // Xử lý sự kiện click nút "X" để xoá mã giảm giá
        document.getElementById('remove-coupon').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định (reload trang)

            // Làm trống ô input và ẩn nút mã giảm giá đã áp dụng
            document.getElementById('coupon-name').textContent = '';
            document.getElementById('coupon-display').style.display = 'none';

            // Làm trống voucher_id khi xoá mã giảm giá
            document.getElementById('voucher-id-input').value = '';
            document.getElementById('id-input').value = '';

            // Cập nhật lại tổng giá khi xoá mã giảm giá
            const totalAmount = parseFloat(document.querySelector('input[name="totalAmount"]').value);
            const discountAmount = 0;
            const newTotal = totalAmount;

            // Cập nhật lại tổng tiền
            document.querySelector('input[name="discount_amount"]').value = discountAmount;
            document.getElementById('discount-amount').textContent =
                `${discountAmount.toLocaleString()} VND`; // Hiển thị giảm giá là 0

            // Cập nhật lại tổng tiền sau khi xoá giảm giá
            document.querySelector('input[name="total_amount"]').value = newTotal;
            document.getElementById('summary-total').textContent = `${newTotal.toLocaleString()} VND`;

            // Hiển thị lại ô input mã giảm giá khi xoá
            document.getElementById('coupon-code-input').style.display = 'block';
        });
    });

    function showBoxVoucherActive(voucherSugggest) {
        console.log("hiii cc ", voucherSugggest);
        // Hiển thị thẻ mã giảm giá đã áp dụng và ẩn ô input
        $('#coupon-display').show();
        $('#coupon-name').text(voucherSugggest.name);

        // Cập nhật voucher_id vào input ẩn
        $('#voucher-id-input').val(voucherSugggest.voucher_id);

        $('#id-input').val(voucherSugggest.id);

        // Cập nhật giảm giá vào tổng giá
        const totalAmount = parseFloat($('input[name="totalAmount"]')
            .val());
        let discountAmount = 0;

        if (voucherSugggest.discount_type === 'PERCENTAGE') {
            discountAmount = Number((voucherSugggest.discount_value / 100)) * totalAmount;
        } else {
            discountAmount = parseFloat(voucherSugggest.discount_value);
            if (totalAmount <= discountAmount) {
                discountAmount = totalAmount;
            }
        }
        // console.log("giam gia", discountAmount);

        const newTotal = totalAmount - discountAmount;

        // Cập nhật giá trị vào giao diện
        $('input[name="discount_amount"]').val(discountAmount);
        $('#discount-amount').text(
            `- ${discountAmount.toLocaleString()} VND`);

        // Cập nhật tổng tiền
        $('input[name="total_amount"]').val(newTotal);
        $('#summary-total').text(`${newTotal.toLocaleString()} VND`);
    }

    function setDefaultAddress(addressId, userId) {
        $.ajax({
            url: '/api/profile/address/set-default/' + addressId,
            type: 'POST',
            data: {
                user_id: userId, // Truyền user_id vào request
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire(response.message, "", "success");
                } else {
                    alert('Có lỗi xảy ra');
                }
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra');
            }
        });
    }
</script>
@include('client.pages.check-out.apply-coupon')
