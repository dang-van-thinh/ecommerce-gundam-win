@extends('client.layouts.master')
@section('title')
    Danh sách sản phẩm
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Danh sách sản phẩm',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])
    <section class="section-b-space pt-0">
        <form action="{{ route('product.filter') }}" method="GET">
            <div class="custom-container container">
                <div class="row">
                    <div class="col-3">
                        {{-- @dd($products) --}}
                        <div class="custom-accordion theme-scrollbar left-box">
                            <div class="left-accordion">
                                <h5>Back </h5><i class="back-button fa-solid fa-xmark"></i>
                            </div>
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <!-- Danh mục -->
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseTwo">
                                            <span>Danh mục</span>
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseTwo">
                                        <div class="accordion-body">
                                            <ul class="catagories-side theme-scrollbar">
                                                @foreach ($categories as $category)
                                                    <li>
                                                        <input class="custom-checkbox" id="category{{ $category->id }}"
                                                            type="checkbox" name="categories[]" value="{{ $category->id }}"
                                                            {{ in_array($category->id, $condited['categories'] ?? []) ? 'checked' : '' }}>
                                                        <label for="category{{ $category->id }}">{{ $category->name }}
                                                            ({{ $category->products_count }})
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Thuộc tính -->
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne">
                                            <span>Thuộc tính</span>
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseOne">
                                        <div class="accordion-body">
                                            <ul class="catagories-side theme-scrollbar">
                                                @foreach ($attributes as $attribute)
                                                    <!-- Hiển thị tên thuộc tính -->
                                                    <h6 style="margin-left: 10px">{{ ucfirst($attribute->name) }}</h6>
                                                    <!-- Lặp qua các giá trị của thuộc tính -->
                                                    @foreach ($attribute->attributeValues as $attributeValue)
                                                        <li>
                                                            <input class="custom-checkbox"
                                                                id="attribute{{ $attributeValue->id }}" type="checkbox"
                                                                {{ in_array($attributeValue->id, $condited['attributes'] ?? []) ? 'checked' : '' }}
                                                                name="attributes[]" value="{{ $attributeValue->id }}">
                                                            <label
                                                                for="attribute{{ $attributeValue->id }}">{{ $attributeValue->name }}</label>
                                                        </li>
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Lọc giá -->
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseFour">
                                            <span>Giá</span>
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseFour">
                                        <div class="accordion-body">
                                            <div class="range-slider">
                                                <input class="range-slider-input" name="minPrice" type="range"
                                                    min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1"
                                                    value="{{ $condited['minPrice'] ?? $minPrice }}" id="minRange"
                                                    oninput="updateMinPriceDisplay()">
                                                <input class="range-slider-input" name="maxPrice" type="range"
                                                    min="{{ $minPrice }}" max="{{ $maxPrice }}" step="1"
                                                    value="{{ $condited['maxPrice'] ?? $maxPrice }}" id="maxRange"
                                                    oninput="updateMaxPriceDisplay()">
                                            </div>
                                            <div class="range-slider-display">
                                                <span>Giá: <span
                                                        id="minPriceDisplay">{{ number_format($condited['minPrice'] ?? $minPrice, 0, ',', '.') }}</span>
                                                    VND</span> -
                                                <span><span
                                                        id="maxPriceDisplay">{{ number_format($condited['maxPrice'] ?? $maxPrice, 0, ',', '.') }}</span>
                                                    VND</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tình trạng -->
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseSix">
                                            <span>Tình trạng</span>
                                        </button>
                                    </h2>
                                    <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSix">
                                        <div class="accordion-body">
                                            <ul class="categories-side d-flex">
                                                <li class="me-3">
                                                    <input class="custom-radio" id="all" type="radio"
                                                        name="stockStatus" value="all"
                                                        {{ ($condited['stockStatus'] ?? 'all') === 'all' ? 'checked' : '' }}>
                                                    <label for="all">Tất cả</label>
                                                </li>
                                                <li class="me-3">
                                                    <input class="custom-radio" id="in_stock" type="radio"
                                                        name="stockStatus" value="inStock"
                                                        {{ ($condited['stockStatus'] ?? 'all') === 'inStock' ? 'checked' : '' }}>
                                                    <label for="in_stock">Còn hàng</label>
                                                </li>
                                                <li>
                                                    <input class="custom-radio" id="out_of_stock" type="radio"
                                                        name="stockStatus" value="outOfStock"
                                                        {{ ($condited['stockStatus'] ?? 'all') === 'outOfStock' ? 'checked' : '' }}>
                                                    <label for="out_of_stock">Hết hàng</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                                <div class="accordion-footer mt-2">
                                    <button style="background-color: #c28f51; border:none" type="submit"
                                        class="btn btn-secondary">Lọc</button>
                                    <button style="background-color: #c28f51; border:none" id="reset" type="button"
                                        class="btn btn-secondary">Đặt lại</button>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header tags-header"><button type="button"
                                            class="accordion-button"><span>Vận
                                                chuyển
                                                &
                                                Giao hàng</span><span></span></button></h2>
                                    <div class="accordion-collapse show collapse" id="panelsStayOpen-collapseSeven">
                                        <div class="accordion-body">
                                            <ul class="widget-card">
                                                <li><i class="iconsax" data-icon="truck-fast"></i>
                                                    <div>
                                                        <h6>Vận chuyển miễn phí</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                    </div>
                                                </li>
                                                <li><i class="iconsax" data-icon="headphones"></i>
                                                    <div>
                                                        <h6>Hỗ trợ 24/7</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                    </div>
                                                </li>
                                                <li><i class="iconsax" data-icon="exchange"></i>
                                                    <div>
                                                        <h6>Hoàn hàng trong 3 ngày</h6>
                                                        <p>Miễn phí vận chuyển cho tất cả các đơn hàng tại Việt nam</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        <div class="sticky">
                            <div style="width: 115%;
                                        padding-left: 44rem ;
                                        display: flex;
                                        justify-content: end;
                                        width: 115%;
                                        float: right;"
                                class="top-filter-menu">
                                <div>
                                    <a class="filter-button btn">
                                        <h6> <i class="iconsax" data-icon="filter"></i>Filter Menu </h6>
                                    </a>
                                    <div class="category-dropdown">
                                        <label for="cars">Sắp xếp :</label>
                                        <select class="form-select" id="cars" name="sort">
                                            <option value="name-asc"
                                                {{ ($condited['sort'] ?? 'name-asc') === 'name-asc' ? 'selected' : '' }}>
                                                Sắp xếp A-Z</option>
                                            <option value="name-desc"
                                                {{ ($condited['sort'] ?? '') === 'name-desc' ? 'selected' : '' }}>Sắp xếp
                                                Z-A</option>
                                            <option value="created-at-desc"
                                                {{ ($condited['sort'] ?? '') === 'created-at-desc' ? 'selected' : '' }}>Mới
                                                nhất</option>
                                            <option value="created-at-asc"
                                                {{ ($condited['sort'] ?? '') === 'created-at-asc' ? 'selected' : '' }}>Cũ
                                                nhất</option>
                                            <option value="best-selling"
                                                {{ ($condited['sort'] ?? '') === 'best-selling' ? 'selected' : '' }}>Bán
                                                chạy nhất</option>
                                            <option value="least-selling"
                                                {{ ($condited['sort'] ?? '') === 'least-selling' ? 'selected' : '' }}>Bán
                                                ít nhất</option>
                                            <option value="price-asc"
                                                {{ ($condited['sort'] ?? '') === 'price-asc' ? 'selected' : '' }}>Giá từ
                                                thấp đến cao</option>
                                            <option value="price-desc"
                                                {{ ($condited['sort'] ?? '') === 'price-desc' ? 'selected' : '' }}>Giá từ
                                                cao đến thấp</option>
                                            <option value="rating-desc"
                                                {{ ($condited['sort'] ?? '') === 'rating-desc' ? 'selected' : '' }}>Đánh
                                                giá từ cao đến thấp</option>
                                            <option value="rating-asc"
                                                {{ ($condited['sort'] ?? '') === 'rating-asc' ? 'selected' : '' }}>Đánh giá
                                                từ thấp đến cao</option>
                                        </select>
                                    </div>
                                    <button style="background-color: #c28f51; border:none" type="submit"
                                        class="btn btn-secondary">Lọc</button>
                                </div>
                            </div>

                            <div id="notification" class="badge badge-success fs-6"
                                style=" color: green; margin-bottom: 15px;">
                                @if (isset($message))
                                    {{ $message }}
                                @endif
                            </div>
                            <div id="productList">
                                @include('client.pages.collection-product.list')
                            </div>
                            <!--Pani nay thi su dung theo cai tra ra du lieu nhe-->
                            <div class="pagination-wrap">
                                {{-- {{ $products->links() }} --}}
                                <ul class="pagination">
                                    @if ($products->onFirstPage())
                                        <li><span class="prev disabled"><i data-icon="chevron-left"></i></span></li>
                                    @else
                                        <li><a class="prev" href="{{ $products->previousPageUrl() }}"><i
                                                    class="iconsax" data-icon="chevron-left"></i></a></li>
                                    @endif

                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="{{ $products->currentPage() == $page ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($products->hasMorePages())
                                        <li><a class="next" href="{{ $products->nextPageUrl() }}"><i class="iconsax"
                                                    data-icon="chevron-right"></i></a></li>
                                    @else
                                        <li><span class="next disabled"><i data-icon="chevron-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            //dat lai cac gia tri
            document.getElementById("reset").addEventListener("click", function(e) {

                window.location.href = "{{ route('product.filter') }}";
            })
        })
        // Hàm khởi tạo sự kiện cho dropdown sắp xếp
        function initSortEvent() {
            const sortSelect = document.getElementById('cars');
            if (sortSelect) {
                sortSelect.removeEventListener('change', handleSubmit); // Gỡ sự kiện cũ để tránh chồng lặp
                sortSelect.addEventListener('change', handleSubmit);
            }
        }

        // Hàm cập nhật hiển thị giá trị tối thiểu
        function updateMinPriceDisplay() {
            const minPrice = document.getElementById('minRange').value;
            document.getElementById('minPriceDisplay').innerText = parseInt(minPrice).toLocaleString('vi-VN');
        }

        // Hàm cập nhật hiển thị giá trị tối đa
        function updateMaxPriceDisplay() {
            const maxPrice = document.getElementById('maxRange').value;
            document.getElementById('maxPriceDisplay').innerText = parseInt(maxPrice).toLocaleString('vi-VN');
        }

        // Khởi tạo sự kiện khi trang được tải
        document.addEventListener('DOMContentLoaded', () => {
            initSortEvent();
            document.getElementById('minRange').addEventListener('input', updateMinPriceDisplay);
            document.getElementById('maxRange').addEventListener('input', updateMaxPriceDisplay);


        });
    </script>
@endsection
