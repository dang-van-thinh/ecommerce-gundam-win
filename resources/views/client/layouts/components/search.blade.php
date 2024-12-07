<style>
    .iconsax {
        border: 0px;
        background-color: transparent;
    }

    .bg-img {
        width: 200px;
        height: 250px;
    }

    @media (max-width: 768px) {

        /* Áp dụng khi màn hình nhỏ hơn 768px */
        .bg-img {
            width: 145.2px;
            height: 152.45px;
        }
    }
</style>
<div class="offcanvas offcanvas-top search-details" id="offcanvasTop" tabindex="-1" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header"><button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"><i
                class="fa-solid fa-xmark"></i></button></div>
    <div class="offcanvas-body theme-scrollbar">
        <div class="container">
            <h3>Bạn Đang Cố Tìm Kiếm Cái Gì?</h3>
            <form id="searchForm" method="post">
                <div class="search-box">
                    <input type="search" name="text" placeholder="Tôi đang tìm kiếm…" />
                    <button type="submit" data-icon="search-normal-2" class="iconsax"></button>
                </div>
                {{-- </form>
            @dd($products); --}}
                <h4>Bạn Có Thể Thích </h4>
                <div id="searchResults" class="row gy-4 ratio_square-2 preemptive-search">
                    @isset($products)
                        @foreach ($products as $product)
                            <div class="col-xl-2 col-sm-4 col-6">
                                <div class="product-box-6">
                                    <div class="img-wrapper">
                                        <div class="product-image" style="position: relative;">
                                            <a href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ asset('storage/' . $product->image) }}"
                                                    alt="product" />
                                            </a>
                                            @if ($product->is_out_of_stock)
                                                <!-- Lớp phủ cho sản phẩm hết hàng -->
                                                <div
                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
                                                    background-color: rgba(0, 0, 0, 0.6); display: flex; 
                                                    justify-content: center; align-items: center; color: #fff; 
                                                    font-size: 25px; font-weight: bold; z-index: 10;">
                                                    HẾT HÀNG
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-detail">
                                        <div><a href="{{ route('product', $product->id) }}">
                                                <h6>{{ $product->name }}</h6>
                                            </a>
                                            <p>
                                                @if ($product->productVariants->count() === 1)
                                                    {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                                @else
                                                    {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫
                                                    -
                                                    {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
                                                @endif
                                            </p>
                                            <ul class="rating">
                                                @php
                                                    $rating = $product->average_rating
                                                        ? ceil($product->average_rating)
                                                        : 0;
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li>
                                                        <i class="fa-solid fa-star"
                                                            style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                                    </li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset

                </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Ngăn chặn hành động gửi form mặc định

                const formData = new FormData(searchForm);
                fetch("{{ route('search') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then((products) => {
                        displayProducts(products);
                    })
                    .catch((error) => {
                        console.error('Có lỗi xảy ra:', error);
                    });
            });

            function displayProducts(products) {
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Xóa các kết quả hiện tại

                if (products.length === 0) {
                    const emptyMessage = document.createElement('p');
                    emptyMessage.textContent = 'Không tìm thấy sản phẩm nào.';
                    searchResults.appendChild(emptyMessage);
                    return;
                }

                products.forEach((product) => {
                    // Tạo các phần tử HTML
                    const colDiv = document.createElement('div');
                    colDiv.className = 'col-xl-2 col-sm-4 col-6';

                    const productBox = document.createElement('div');
                    productBox.className = 'product-box-6';

                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'img-wrapper';

                    const productImage = document.createElement('div');
                    productImage.className = 'product-image';
                    productImage.style.position = 'relative';

                    const anchor = document.createElement('a');
                    anchor.href = `/product/${product.id}`;

                    const img = document.createElement('img');
                    img.className = 'bg-img';
                    img.src = `/storage/${product.image}`;
                    img.alt = product.name;

                    anchor.appendChild(img);
                    productImage.appendChild(anchor);

                    // Thêm lớp phủ nếu hết hàng
                    if (product.is_out_of_stock) {
                        const overlay = document.createElement('div');
                        overlay.style.position = 'absolute';
                        overlay.style.top = '0';
                        overlay.style.left = '0';
                        overlay.style.width = '100%';
                        overlay.style.height = '100%';
                        overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
                        overlay.style.display = 'flex';
                        overlay.style.justifyContent = 'center';
                        overlay.style.alignItems = 'center';
                        overlay.style.color = '#fff';
                        overlay.style.fontSize = '25px';
                        overlay.style.fontWeight = 'bold';
                        overlay.textContent = 'HẾT HÀNG';
                        productImage.appendChild(overlay);
                    }

                    imgWrapper.appendChild(productImage);
                    productBox.appendChild(imgWrapper);

                    const productDetail = document.createElement('div');
                    productDetail.className = 'product-detail';

                    const detailDiv = document.createElement('div');

                    const detailAnchor = document.createElement('a');
                    detailAnchor.href = `/product/${product.id}`;

                    const h6 = document.createElement('h6');
                    h6.textContent = product.name;

                    detailAnchor.appendChild(h6);
                    detailDiv.appendChild(detailAnchor);

                    const price = document.createElement('p');
                    if (product.product_variants.length === 1) {
                        price.textContent = `${formatCurrency(product.product_variants[0].price)}`;
                    } else {
                        const minPrice = Math.min(...product.product_variants.map((v) => v.price));
                        const maxPrice = Math.max(...product.product_variants.map((v) => v.price));
                        price.textContent = `${formatCurrency(minPrice)} - ${formatCurrency(maxPrice)}`;
                    }

                    detailDiv.appendChild(price);

                    const ratingList = document.createElement('ul');
                    ratingList.className = 'rating';

                    const rating = product.average_rating ? Math.ceil(product.average_rating) : 0;
                    for (let i = 1; i <= 5; i++) {
                        const li = document.createElement('li');
                        const starIcon = document.createElement('i');
                        starIcon.className = 'fa-solid fa-star';
                        starIcon.style.color = i <= rating ? '#f39c12' : '#000';
                        li.appendChild(starIcon);
                        ratingList.appendChild(li);
                    }

                    detailDiv.appendChild(ratingList);
                    productDetail.appendChild(detailDiv);
                    productBox.appendChild(productDetail);
                    colDiv.appendChild(productBox);

                    searchResults.appendChild(colDiv); // Thêm sản phẩm vào kết quả
                });
            }

            // Hàm định dạng giá
            function formatCurrency(amount) {
                return amount.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            }
        });
    </script>
@endpush
