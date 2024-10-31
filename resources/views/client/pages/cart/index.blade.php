@extends('client.layouts.master')
@section('title')
    Giỏ hàng
@endsection
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
            <div class="row g-4">
                <div class="col-12">
                    <div class="cart-countdown"><img src="../assets/images/gif/fire-2.gif" alt="">
                        <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart. We'll
                            keep it for you for<span id="countdown"></span>minutes.</h6>
                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8">
                    <div class="cart-table">
                        <div class="table-title">
                            <h5>Cart<span id="cartTitle">(3)</span></h5><button id="clearAllButton">Clear All</button>
                        </div>
                        <div class="table-responsive theme-scrollbar">
                            <table class="table" id="cart-table">
                                <thead>
                                    <tr>
                                        <th>Product </th>
                                        <th>Price </th>
                                        <th>Quantity</th>
                                        <th>Total</th>
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
                        <div class="no-data" id="data-show"><img src="../assets/images/cart/1.gif" alt="">
                            <h4>You have nothing in your shopping cart!</h4>
                            <p>Today is a great day to purchase the things you have been holding onto! or <span>Carry on
                                    Buying</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4">
                    <div class="cart-items">
                        <div class="cart-progress">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 43%"
                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><span> <i class="iconsax"
                                            data-icon="truck-fast"></i></span></div>
                            </div>
                            <p>Almost there, add <span>$267.00 </span>more to get <span>FREE Shipping !! </span></p>
                        </div>
                        <div class="cart-body">
                            <h6>Price Details (3 Items) </h6>
                            <ul>
                                <li>
                                    <p>Bag total </p><span>$220.00 </span>
                                </li>
                                <li>
                                    <p>Bag savings </p><span class="theme-color">-$20.00 </span>
                                </li>
                                <li>
                                    <p>Coupon Discount </p><span class="Coupon">Apply Coupon </span>
                                </li>
                                <li>
                                    <p>Delivery </p><span>$50.00 </span>
                                </li>
                            </ul>
                        </div>
                        <div class="cart-bottom">
                            <p><i class="iconsax me-1" data-icon="tag-2"></i>SPECIAL OFFER (-$1.49) </p>
                            <h6>Subtotal <span>$158.41 </span></h6><span>Taxes and shipping calculated at
                                checkout</span>
                        </div>
                        <div class="coupon-box">
                            <h6>Coupon</h6>
                            <ul>
                                <li> <span> <input type="text" placeholder="Apply Coupon"><i class="iconsax me-1"
                                            data-icon="tag-2"> </i></span><button class="btn">Apply </button></li>
                                <li> <span> <a class="theme-color" href="login.html">Login </a>to see best coupon for
                                        you </span></li>
                            </ul>
                        </div>
                        <a class="btn btn_black w-100 sm rounded" href="{{ route('check-out') }}">Thanh toán</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="cart-slider">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h6>For a trendy and modern twist, especially during transitional seasons.</h6>
                                <p> <img class="me-2" src="../assets/images/gif/discount.gif" alt="">You will
                                    get 10%
                                    OFF on each product</p>
                            </div><a class="btn btn_outline sm rounded" href="product.html">View All<svg>
                                    <use href="../assets/svg/icon-sprite.svg#arrow"></use>
                                </svg></a>
                        </div>
                        <div class="swiper cart-slider-box">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product.html"> <img src="../assets/images/user/4.jpg"
                                                alt=""></a>
                                        <div> <a href="product.html">
                                                <h5>Polo-neck Body Dress</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$19.90 <span> <del>$14.90 </del></span></p><a class="btn"
                                                href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product.html"> <img src="../assets/images/user/5.jpg"
                                                alt=""></a>
                                        <div> <a href="product.html">
                                                <h5>Short Sleeve Sweater</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$22.90 <span> <del>$24.90 </del></span></p><a class="btn"
                                                href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product.html"> <img src="../assets/images/user/6.jpg"
                                                alt=""></a>
                                        <div> <a href="product.html">
                                                <h5>Oversized Cotton Short</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$10.90 <span> <del>$18.90 </del></span></p><a class="btn"
                                                href="#">Add</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="cart-box"> <a href="product.html"> <img src="../assets/images/user/7.jpg"
                                                alt=""></a>
                                        <div> <a href="product.html">
                                                <h5>Oversized Women Shirt</h5>
                                            </a>
                                            <h6>Sold By: <span>Brown Shop</span></h6>
                                            <div class="category-dropdown"><select class="form-select" name="carlist">
                                                    <option value="">Best color</option>
                                                    <option value="">White</option>
                                                    <option value="">Black</option>
                                                    <option value="">Green</option>
                                                </select></div>
                                            <p>$15.90 <span> <del>$20.90 </del></span></p><a class="btn"
                                                href="#">Add</a>
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
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                    let variantId = $(this).attr('data-variant');
                    console.log("Nút có ID là:", variantId);
                    alert("dung");
                    let data = {
                        userId: @php
                            echo Auth::id();
                        @endphp,
                        variantId: variantId,
                    }
                    deleteProductCart(data);
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
                const plusMinus = document.querySelectorAll('.quantity');
                plusMinus.forEach((element) => {
                    const addButton = element.querySelector('.plus');
                    const subButton = element.querySelector('.minus');

                    addButton?.addEventListener('click', function() {
                        let selectedVariant = document.querySelector('.variant-option.selected');
                        const maxQuantity = parseInt(document.querySelector("#quantity_variant")
                            .getAttribute('max'));
                        const inputEl = this.parentNode.querySelector("input[type='number']");

                        if (inputEl.value < maxQuantity) {
                            inputEl.value = Number(inputEl.value) + 1;
                        }
                    });


                    subButton?.addEventListener('click', function() {
                        const inputEl = this.parentNode.querySelector("input[type='number']");
                        if (inputEl.value >= 2) {
                            inputEl.value = Number(inputEl.value) - 1;
                        }
                    });
                });
            }

            function showTable() {
                const tableBody = document.querySelector('#show-product'); // giả sử bạn có một tbody với id này

                // Xóa dữ liệu cũ
                tableBody.innerHTML = '';

                // Lặp qua từng sản phẩm để tạo các hàng
                if (productResponse.length > 0) {
                    productResponse.forEach(item => {
                        const row = document.createElement('tr');

                        // Cột sản phẩm
                        const productCell = document.createElement('td');
                        const cartBox = document.createElement('div');
                        cartBox.className = 'cart-box';

                        // Ảnh sản phẩm
                        const imgLink = document.createElement('a');
                        imgLink.href = 'product.html';
                        const img = document.createElement('img');
                        img.src = `/storage/${item.product.image}`;
                        img.alt = '';
                        imgLink.appendChild(img);
                        cartBox.appendChild(imgLink);

                        // Thông tin sản phẩm
                        const infoDiv = document.createElement('div');
                        const nameLink = document.createElement('a');
                        nameLink.href = 'product.html';
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
                        minusButton.innerHTML = '<i class="fa-solid fa-minus"></i>';
                        quantityDiv.appendChild(minusButton);

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'number';
                        quantityInput.id = 'quantity_variant';
                        quantityInput.value = item.cart.quantity;
                        quantityInput.min = 1;
                        quantityInput.max = item.product_variant.quantity;
                        quantityDiv.appendChild(quantityInput);

                        const plusButton = document.createElement('button');
                        plusButton.className = 'plus';
                        plusButton.innerHTML = '<i class="fa-solid fa-plus"></i>';
                        quantityDiv.appendChild(plusButton);

                        quantityCell.appendChild(quantityDiv);
                        row.appendChild(quantityCell);

                        // Tổng giá
                        const totalCell = document.createElement('td');
                        const total = item.product_variant.price * item.cart.quantity;
                        totalCell.textContent = `${new Intl.NumberFormat().format(total)} VND`;
                        row.appendChild(totalCell);

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

                    });
                } else {
                    let div = `<div> Giỏ hàng trông </div>`;
                    tableBody.appendChild(div);
                }
            };
            showBtn();
        });
    </script>
@endpush
