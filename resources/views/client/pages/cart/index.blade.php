@extends('client.layouts.master')
@section('title')
    Giỏ hàng
@endsection
@push('css')
    <style>
        td {
            white-space: nowrap;
            /* Giữ văn bản trên một dòng */
            overflow: hidden;
            /* An văn bản vượt quá giới hạn */
            text-overflow: ellipsis;
            /* Hiển thị dâu'...' khi văn bản vượt quá */
            max-width: 200px;
            /* Đặt chiêu rộng tôi đa cho ô văn bản */
        }
    </style>
@endpush
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Giỏ hàng',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])

    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div id="item_not_product"> </div>
            <form action="{{ route('check-out') }}" method="get" class="mt-4">
                <div class="row g-4" id="item_has_product">

                    <div class="col-12">
                        <div class="cart-countdown"><img src="../assets/images/gif/fire-2.gif" alt="">
                            <h6>Xin hãy nhanh chân! Có người đã đặt hàng một trong những mặt hàng bạn có trong giỏ hàng.
                                Chúng
                                tôi sẽ giữ hàng cho bạn trong <span id="countdown"></span> phút.</h6>
                        </div>
                    </div>
                    <div class="col-xxl-9 col-xl-8">
                        <div class="cart-table">
                            <div class="table-title">
                                {{-- <h5>Giỏ hàng<span id="cartTitle"></span></h5><button id="clearAllButton">Clear All</button> --}}
                            </div>
                            <div class="table-responsive theme-scrollbar">
                                <table class="table" id="cart-table">
                                    <thead>
                                        <tr>
                                            <th width="40px">
                                                <input type="checkbox" name="selected_all">
                                            </th>
                                            <th
                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px;">
                                                Sản phẩm </th>
                                            <th>Giá </th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="show-product">
                                        {{-- @foreach ($productResponse as $key => $item)
                                        <tr>
                                            <td>
                                                <div class="cart-box">
                                                    <a href="product.html">
                                                        <img src="{{ '/storage/' . $item['product']['image'] }}"
                                                            alt=""></a>
                                                    <div>
                                                        <a href="product.html">
                                                            <h5>{{ $item['product']['name'] }}</h5>
                                                        </a>
                                                        @foreach ($item['product_variant']['attribute_values'] as $variant)
                                                            <p>{{ $variant['attribute']['name'] }}: <span>
                                                                    {{ $variant['name'] }} </span></p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{ number_format($item['product_variant']['price'], 0, ',', '.') }} VND
                                            </td>
                                            <td>
                                                <div class="quantity">
                                                    <button class="minus" type="button"><i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <input type="number" id="quantity_variant" value="{{ $item['cart']['quantity'] }}"
                                                        min="1" max="{{ $item['product_variant']['quantity'] }}">
                                                    <button class="plus" type="button">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <!-- tong -->
                                            <td> {{ number_format($item['product_variant']['price'] * $item['cart']['quantity'], 0, ',', '.') }}
                                                VND </td>
                                            <td>
                                                <a class="deleteButton" data-variant= "{{ $item['cart']['id'] }}"
                                                    href="javascript:void(0)">
                                                    <i class="iconsax" data-icon="trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            <div id="data-nothing">

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4">
                        <div class="cart-items">
                            {{-- <div class="cart-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 43%"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span> <i class="iconsax"
                                            data-icon="truck-fast"></i></span></div>
                            </div>
                            <p>Almost there, add <span>$267.00 </span>more to get <span>FREE Shipping !! </span></p>
                        </div> --}}
                            {{-- <div class="cart-body mt-0">
                            <h6>Chi tiết giá </h6>
                            <ul>
                                <li>
                                    <p>Tổng </p><span id="cart_total_detail">$220.00 </span>
                                </li>
                                <li>
                                    <p>Tiết kiệm được </p><span class="theme-color">-$20.00 </span>
                                </li>
                                <li>
                                    <p>Vận chuyển </p><span>$50.00 </span>
                                </li>
                            </ul>
                        </div> --}}
                            <div class="cart-bottom">
                                {{-- <p><i class="iconsax me-1" data-icon="tag-2"></i>Khuyến mãi đặc biệt (-$1.49) </p> --}}
                                <h6>Tổng cộng
                                    <span id="cart_total">0 </span>
                                </h6>
                                <span>Thuế và phí vận chuyển được tính khi thanh toán</span>
                            </div>
                            {{-- <div class="coupon-box">
                            <h6>Mã giảm giá</h6>
                            <ul>
                                <li>
                                    <span>
                                        <input type="text" placeholder="Sử dụng mã giảm giá"><i class="iconsax me-1"
                                            data-icon="tag-2"> </i>
                                    </span>
                                    <button style="font-size: 14px; padding: 5px; width: 107px;" class="btn w-50%">Áp
                                        dụng</button>
                                </li>
                            </ul>
                        </div> --}}

                            <div>
                                <button type="submit" class="btn btn_black w-100 sm rounded" id="submit_checkout">Thanh
                                    toán</button>

                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @php
            $productJson = json_encode($productResponse);
        @endphp
        let productResponse = {!! $productJson !!};
        console.log(productResponse);

        $(document).ready(function() {

            showTable();

            deleteBtn()
            // xoa sp ra khoi gio hangv
            function deleteBtn() {
                let btnDelete = $('.deleteButton');
                btnDelete.on('click', function() {
                    let cart = $(this).attr('data-variant');
                    console.log("Nút có ID là:", cart);
                    // alert("dung");
                    let data = {
                        "userId": @php
                            echo Auth::id();
                        @endphp,
                        "cartId": cart,
                    }
                    Swal.fire({
                        title: "Bạn có muốn xóa sản phẩm này ra khỏi giỏ hàng ?",
                        icon: "warning",
                        confirmButtonText: "Đồng ý",
                        showCancelButton: true,
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteProductCart(data);
                        }
                    });
                });
            }


            // cap nhat so luong san pham
            function updateQuantity(data) {
                $.ajax({
                    type: "PUT",
                    url: '{{ route('api.update-cart') }}',
                    data: data,
                    success: function(response) {
                        console.log(response);
                        return true;
                    }
                });
            }


            function deleteProductCart(data) {
                $.ajax({
                    type: "DELETE",
                    url: '{{ route('api.delete-cart') }}',
                    data: data,
                    success: function(response) {
                        console.log(response.message);
                        let numberCart = response.message.numberCart;
                        document.querySelector("#numberCart").innerText = numberCart;
                        // gan lai du lieu
                        productResponse = response.message.productCart;
                        showTable();
                        showBtn();
                        deleteBtn();
                    }
                });

            }

            function showBtn() {
                let totalPrice = document.querySelectorAll(".totalPrice");
                const plusMinus = document.querySelectorAll('.quantity');
                const inputVariants = document.querySelectorAll('.input_variant');
                const cartsCheckboxes = document.querySelectorAll('input[name="selected_carts[]"]:not([disabled])');

                // xu ly su kien selected_all
                const selectedAll = document.querySelector("input[name=selected_all]");
                selectedAll.addEventListener("change", function() {
                    if (selectedAll.checked) {
                        cartsCheckboxes.forEach(check => {
                            check.checked = true;
                        })
                    } else {
                        cartsCheckboxes.forEach(check => {
                            check.checked = false;
                        })
                    }
                    showCartTotalPrice()
                })

                // Lặp qua tất cả checkbox và thêm sự kiện click
                cartsCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        showCartTotalPrice()
                    });
                });

                inputVariants.forEach((inputVariant, index) => {
                    inputVariant.addEventListener('change', function() {
                        let max = parseInt(this.getAttribute('max'));
                        console.log(this.value);
                        if (this.value > 0 && this.value < max) {
                            let data = {
                                'cartId': inputVariant.dataset.id,
                                'quantity': inputVariant.value
                            };
                            updateQuantity(data);
                            // thay doi hien thị tổng tiền
                            let total = Number(inputVariant.dataset.price * inputEl.value)
                            console.log(total);
                            totalPrice[index].innerHTML =
                                `${new Intl.NumberFormat("vi-VN").format(total)} VND`;
                        } else {
                            if (this.value < 0) {
                                Swal.fire({
                                    title: "Số lượng sản phẩm mua không được nhỏ hơn 1 !",
                                    icon: "warning",
                                    confirmButtonText: "OK"
                                })
                                this.value = 1
                                let data = {
                                    'cartId': inputVariant.dataset.id,
                                    'quantity': 1
                                };
                                updateQuantity(data);
                            } else if (this.value > max) {
                                Swal.fire({
                                    title: `Số lượng sản phẩm mua không được lớn hơn số lượng trong kho hiện tại là ${max} !`,
                                    icon: "warning",
                                    confirmButtonText: "OK"
                                })
                                this.value = max
                                let data = {
                                    'cartId': inputVariant.dataset.id,
                                    'quantity': max
                                };
                                updateQuantity(data);
                            }

                        }

                    })
                })

                plusMinus.forEach((element, index) => {
                    const addButton = element.querySelector('.plus');
                    const subButton = element.querySelector('.minus');

                    addButton?.addEventListener('click', function() {

                        let selectedVariant = document.querySelector('.variant-option.selected');
                        const maxQuantity = parseInt(this.parentNode.querySelector(
                                ".quantity_variant")
                            .getAttribute('max'));
                        // console.log("max : ",maxQuantity)
                        const inputEl = this.parentNode.querySelector("input[type='number']");

                        if (inputEl.value < maxQuantity) {
                            inputEl.value = Number(inputEl.value) + 1;
                            let data = {
                                'cartId': addButton.dataset.id,
                                'quantity': inputEl.value
                            };
                            updateQuantity(data)

                            // thay doi hien thị tổng tiền
                            let total = Number(addButton.dataset.price * inputEl.value)
                            console.log(total);
                            totalPrice[index].innerHTML = new Intl.NumberFormat().format(total) +
                                ' VND';
                            showCartTotalPrice()
                        }
                    });

                    subButton?.addEventListener('click', function() {
                        const inputEl = this.parentNode.querySelector("input[type='number']");
                        if (inputEl.value >= 2) {
                            inputEl.value = Number(inputEl.value) - 1;
                            let data = {
                                'cartId': addButton.dataset.id,
                                'quantity': inputEl.value
                            };
                            updateQuantity(data)
                            // thay doi hien thị tổng tiền
                            let total = Number(subButton.dataset.price * inputEl.value)
                            // console.log(total);
                            totalPrice[index].innerHTML = new Intl.NumberFormat().format(total) +
                                ' VND';
                            showCartTotalPrice()
                        }
                    });
                });
            }

            function showCartTotalPrice() {
                const cartsCheckboxes = document.querySelectorAll('input[name="selected_carts[]"]:checked');
                const allCheckboxes = document.querySelectorAll('input[name="selected_carts[]"]:not([disabled])');
                let parentCheckbox = document.querySelector("input[name=selected_all]");
                // console.log(cartsCheckboxes.length, allCheckboxes.length, parentCheckbox.checked);
                let totalSelectedPrice = 0;

                // Lặp qua tất cả checkbox để tính tổng giá trị của những checkbox đã chọn
                allCheckboxes.forEach(checkbox => {
                    // xu ly su kien check box het
                    if (allCheckboxes.length === cartsCheckboxes.length && allCheckboxes.length > 0) {
                        // console.log(cartsCheckboxes.length);
                        parentCheckbox.checked = true;
                    } else {
                        parentCheckbox.checked = false;
                        // console.log(cartsCheckboxes.length);
                    }

                    if (checkbox.checked) {
                        let priceOfCartItem = checkbox.closest("tr").querySelector(".totalPrice")
                            .textContent.trim().replace(/[^0-9]/g, '');
                        console.log(priceOfCartItem);
                        totalSelectedPrice += parseFloat(priceOfCartItem); // Lấy giá trị từ data-price
                    }
                });

                // Hiển thị tổng giá trị của các sản phẩm đã chọn
                console.log('Tổng giá trị các sản phẩm đã chọn:', totalSelectedPrice);

                // Nếu bạn muốn hiển thị tổng giá trị ở đâu đó trên giao diện
                document.querySelector("#cart_total").innerText =
                    `${Intl.NumberFormat('vi-VN').format(totalSelectedPrice)} VND`;
                // let totalSelectedPrice = 0;
            }

            function showTable() {
                const tableBody = document.querySelector('#show-product'); // giả sử bạn có một tbody với id này
                let cartTotalPrice = 0;
                // Xóa dữ liệu cũ
                tableBody.innerHTML = '';

                // Lặp qua từng sản phẩm để tạo các hàng
                if (productResponse.length > 0) {
                    productResponse.forEach(item => {
                        const productRoute = `{{ route('product', ':id') }}`;
                        const row = document.createElement('tr');
                        console.log(item.cart);

                        // cột checkbox 
                        const checkboxCell = document.createElement('td');
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'selected_carts[]';
                        checkbox.value = item.cart.id;
                        // checkbox.className = '';

                        checkbox.dataset.id = item.cart.id; // Gán ID sản phẩm vào data attribute nếu cần
                        checkboxCell.appendChild(checkbox);
                        row.appendChild(checkboxCell); // Thêm cột checkbox vào hàng

                        // Cột sản phẩm
                        const productCell = document.createElement('td');
                        const cartBox = document.createElement('div');
                        cartBox.className = 'cart-box';

                        // Ảnh sản phẩm
                        const imgLink = document.createElement('a')
                        const overStock = document.createElement("div")
                        imgLink.style.position = 'relative';
                        imgLink.href = productRoute.replace(':id', item.product.id);
                        const img = document.createElement('img');
                        img.src = `/storage/${item.product.image}`;
                        img.alt = '';
                        imgLink.appendChild(img);
                        cartBox.appendChild(imgLink);

                        overStock.innerHTML = `
                            <div style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background-color: rgba(0, 0, 0, 0.6);
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                color: #fff;
                                font-size: 11px;
                                font-weight: bold;
                                z-index: 10;
                            ">
                                HẾT HÀNG
                            </div>
                        `;

                        // Lớp phủ khi sản phẩm ngưng bán
                        let overInactive = document.createElement('div');
                        overInactive.innerHTML = `
                            <div style="
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                background-color: rgba(0, 0, 0, 0.6);
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                color: #fff;
                                font-size: 11px;
                                font-weight: bold;
                                z-index: 10;
                            ">
                                NGƯNG BÁN
                            </div>
                        `;

                        // Kiểm tra nếu sản phẩm ngưng bán (ưu tiên trạng thái ngưng bán)
                        if (item.product.status === 'IN_ACTIVE') {
                            imgLink.appendChild(overInactive);
                            checkbox.disabled = true;
                        } else if (item.product_variant.quantity <= 0) {
                            // Kiểm tra nếu sản phẩm hết hàng (chỉ hiển thị khi không phải là ngưng bán)
                            imgLink.appendChild(overStock);
                            checkbox.disabled = true;
                        }

                        // Thông tin sản phẩm
                        const infoDiv = document.createElement('div');
                        const nameLink = document.createElement('a');
                        nameLink.href = productRoute.replace(':id', item.product.id);

                        const name = document.createElement('h5');
                        name.textContent = item.product.name;
                        nameLink.appendChild(name);
                        infoDiv.appendChild(nameLink);



                        // Biến thể sản phẩm
                        item.product_variant.attribute_values.forEach(variant => {
                            const variantP = document.createElement('p');
                            variantP.innerHTML =
                                `${variant.attribute.name}: <span>${variant.name}</span>`;
                            infoDiv.appendChild(variantP);
                        });

                        cartBox.appendChild(infoDiv);
                        productCell.appendChild(cartBox);
                        row.appendChild(productCell);

                        // Giá sản phẩm
                        const priceCell = document.createElement('td');
                        priceCell.textContent =
                            `${new Intl.NumberFormat().format(item.product_variant.price)} VND`;
                        row.appendChild(priceCell);

                        // Số lượng
                        const quantityCell = document.createElement('td');
                        const quantityDiv = document.createElement('div');
                        quantityDiv.className = 'quantity';

                        const minusButton = document.createElement('button');
                        minusButton.className = 'minus';
                        minusButton.type = 'button';
                        minusButton.dataset.id = item.cart.id;
                        minusButton.dataset.price = item.product_variant.price
                        minusButton.innerHTML = '<i class="fa-solid fa-minus"></i>';
                        quantityDiv.appendChild(minusButton);

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'number';
                        // quantityInput.id = '';
                        quantityInput.className = 'input_variant quantity_variant';
                        quantityInput.dataset.id = item.cart.id;
                        quantityInput.value = item.cart.quantity;
                        quantityInput.min = 1;
                        quantityInput.max = item.product_variant.quantity < 1 ? 1 : item.product_variant
                            .quantity; // so luong trong kho la 0 thi gan tam max la 1 , vi thuoc tinh cua the input nó sa bao loi
                        quantityDiv.appendChild(quantityInput);

                        const plusButton = document.createElement('button');
                        plusButton.className = 'plus';
                        plusButton.type = 'button';
                        plusButton.dataset.id = item.cart.id;
                        plusButton.dataset.price = item.product_variant.price
                        plusButton.innerHTML = '<i class="fa-solid fa-plus"></i>';
                        quantityDiv.appendChild(plusButton);

                        quantityCell.appendChild(quantityDiv);
                        row.appendChild(quantityCell);

                        // Tổng giá
                        const totalCell = document.createElement('td');
                        const total = item.product_variant.price * item.cart.quantity;
                        let totalItemCell = new Intl.NumberFormat().format(total);
                        totalCell.className = 'totalPrice';
                        totalCell.textContent = `${totalItemCell} VND`;
                        row.appendChild(totalCell);
                        cartTotalPrice += Number(total);

                        // Nút xóa
                        const deleteCell = document.createElement('td');
                        const deleteButton = document.createElement('a');
                        deleteButton.className = 'deleteButton';
                        deleteButton.dataset.variant = item.cart.id;
                        deleteButton.href = 'javascript:void(0)';
                        deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                        deleteCell.appendChild(deleteButton);
                        row.appendChild(deleteCell);

                        // Thêm hàng vào bảng
                        tableBody.appendChild(row);
                        document.querySelector("#cart_total").innerText =
                            `0 VND`;
                    });
                } else {
                    console.log(productResponse);
                    document.querySelector('#item_has_product').style.display = 'none';

                    let div = `<div class='text-center' >
                        <img src="/template/client/assets/images/cart/1.gif" alt="">
                            <h4>Bạn không có gì trong giỏ hàng !</h4>
                            <p>Hôm nay là một ngày tuyệt vời để mua những thứ bạn đã giữ! hoặc
                                <a href='{{ route('home') }}'>Tiếp tục mua</a></div>`;
                    document.querySelector("#item_not_product").innerHTML = div;
                    // tableBody.appendChild(div);
                }
                showCartTotalPrice()
            };
            showBtn();
        });
    </script>
@endpush
