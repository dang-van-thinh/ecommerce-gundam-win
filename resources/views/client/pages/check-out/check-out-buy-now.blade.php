@extends('client.layouts.master')
@section('title')
    Thanh toán đơn hàng
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Thanh toán đơn hàng',
        'parent' => [
            'route' => '',
            'name' => '',
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
        <form action="{{ route('place-order-buy-now') }}" method="POST">
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
                                                            name="address_user_id">
                                                    </span>
                                                    <span class="address-detail">

                                                        <span class="address">
                                                            <span class="address-title"> Địa chỉ {{ $key + 1 }}</span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag"> Địa chỉ:</span>
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
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="cod" type="radio" checked="checked"
                                                value="cod" name="payment_method">
                                            <label for="cod">Thanh toán khi nhận hàng</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="momo" type="radio"
                                                name="payment_method" value="momo">
                                            <label for="momo">Thanh toán qua MOMO</label>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="vnpay" type="radio"
                                                name="payment_method" value="vnpay">
                                            <label for="vnpay">Thanh toán qua VNPAY</label>

                                        </div>
                                    </div>
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
        // lay du lieu san pham mua ngay
        const productStorage = JSON.parse(localStorage.getItem('productBuyNow'));
        console.log(productStorage);

        function handleProduct() {
            $.ajax({
                type: "get",
                url: "{{ route('api.product-variant') }}",
                data: productStorage,
                success: function(response) {
                    console.log(response);
                    showProduct(response.productResponse, response.quantity)
                }
            });
        }
        handleProduct();

        function showProduct(productResponse, quantityP) {
            let totalAmount = 0;
            const price = parseFloat(productResponse.price); // Giá sản phẩm
            const quantity = quantityP; // Số lượng sản phẩm
            const itemTotal = price * quantity; // Tổng tiền sản phẩm

            // Tính tổng giá
            totalAmount += itemTotal;

            // Bắt đầu tạo HTML cho sản phẩm
            const cartListing = $(".cart-listing");
            const productList = $("<ul></ul>");

            // Tạo mục sản phẩm
            const productItem = $("<li></li>");

            // Tạo phần hình ảnh sản phẩm
            const productImage = $("<img>")
                .attr("width", "60px")
                .attr("src", "/storage/" + productResponse.product.image)
                .attr("alt", "");

            // Tạo phần chi tiết sản phẩm
            const productDetails = $("<div></div>");
            const productName = $("<h6></h6>").text(productResponse.product.name);
            const variantHidden = $("<input>").attr('type', 'hidden').attr('name', 'variant')
                .val(`${productResponse.id}`);
            productDetails.append(productName);
            productDetails.append(variantHidden);

            // Tạo danh sách thuộc tính sản phẩm
            productResponse.attribute_values.forEach(function(variant) {
                const variantDetail = $("<p></p>").html(
                    `${variant.attribute.name}: <span>${variant.name}</span>`
                );
                productDetails.append(variantDetail);
            });

            // Hiển thị số lượng sản phẩm
            const quantityN = $("<p></p>").addClass("fs-6").text(`Số lượng: ${quantity}`);
            const quantityHidden = $("<input>").addClass("fs-6").attr('type', 'hidden').attr('name', 'quantity')
                .val(`${quantity}`);
            productDetails.append(quantityN);
            productDetails.append(quantityHidden);

            // Hiển thị giá của sản phẩm
            const priceN = $("<p></p>").text(price.toLocaleString("vi-VN") + " VND");

            // Thêm hình ảnh, chi tiết và giá vào mục sản phẩm
            productItem.append(productImage, productDetails, $("<div></div>"), priceN);
            productList.append(productItem);

            // Tạo tổng kết giỏ hàng
            const summaryTotal = $("<div></div>").addClass("summary-total");
            const totalList = $("<ul></ul>");
            const totalItem = $("<li></li>");
            const totalLabel = $("<p></p>").text("Tổng giá");
            const totalHiddenInput = $("<input>").attr("type", "hidden").attr("name", "totalAmount").val(
                totalAmount);
            const totalAmountText = $("<span></span>").text(totalAmount.toLocaleString("vi-VN") + " VND");

            totalItem.append(totalLabel, totalHiddenInput, totalAmountText);
            totalList.append(totalItem);
            summaryTotal.append(totalList);

            // Hiển thị tổng số tiền
            const totalDiv = $("<div></div>").addClass("total");
            const totalText = $("<h6></h6>").text("Thành tiền : ");
            const totalAmountTextFinal = $("<h6></h6>").text(totalAmount.toLocaleString("vi-VN") + " VND");
            const hiddenTotalInput = $("<input>").attr("type", "hidden").attr("name", "total_amount").val(
                totalAmount);
            totalDiv.append(totalText, totalAmountTextFinal, hiddenTotalInput);

            // Tạo nút đặt hàng
            const orderButtonDiv = $("<div></div>").addClass("order-button");
            const orderButton = $("<button></button>")
                .attr("type", "submit")
                .addClass("btn btn_black sm w-100 rounded")
                .text("Đặt hàng");
            orderButtonDiv.append(orderButton);

            // Thêm tất cả vào giỏ hàng
            cartListing.append(productList, summaryTotal, totalDiv, orderButtonDiv);
        }

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
</script>
