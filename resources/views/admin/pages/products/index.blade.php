@extends('admin.layouts.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách sản phẩm</strong>
        </div>

        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success" href="{{ route('products.create') }}">Thêm mới</a>
            </div>

            <!-- Bộ lọc và tìm kiếm -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="product-search" class="form-control" placeholder="Tìm kiếm mã hoặc tên sản phẩm">
                </div>
            </div>

            <!-- Bảng sản phẩm -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="1px">STT</th>
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Giá</th>
                            <th scope="col">
                                <select class="form-select" id="status-filter">
                                    <option value="all">Trạng thái</option>
                                    <option value="ACTIVE">Hoạt động</option>
                                    <option value="IN_ACTIVE">Vô hiệu hoá</option>
                                </select>
                            </th>
                            <th scope="col"> 
                                <select class="form-select" id="category-filter">
                                <option value="all">Danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            </th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="productData">
                        <!-- Dữ liệu sản phẩm sẽ được tải động -->
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div id="pagination" class="mt-3">
                <!-- Phân trang sẽ được tải động -->
            </div>
        </div>
    </div>
@endsection

@push('admin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentPage = 1;

        // Hàm tải danh sách sản phẩm
        function fetchProducts(page = 1) {
            let category = $('#category-filter').val();
            let search = $('#product-search').val();
            let status = $('#status-filter').val(); // Lấy trạng thái từ bộ lọc

            $.ajax({
                url: `/api/admin/products/filter?page=${page}`,
                type: 'GET',
                data: { category: category, search: search, status: status }, // Thêm trạng thái vào dữ liệu
                success: function(response) {
                    $('#productData').empty();

                    // Hiển thị danh sách sản phẩm
                    response.products.data.forEach(function(product, index) {
                        $('#productData').append(`
                            <tr>
                                <td>${(page - 1) * 5 + index + 1}</td>
                                <td>${product.code}</td>
                                <td>
                                    ${product.image ? `<img src="/storage/${product.image}" alt="Ảnh" width="50px">` : ''}
                                </td>
                                <td>${product.name}</td>
                                <td>
                                    ${product.product_variants.length === 1
                                        ? `${new Intl.NumberFormat('vi-VN').format(product.product_variants[0].price)} VND`
                                        : `${new Intl.NumberFormat('vi-VN').format(product.product_variants[0]?.price)} - ${new Intl.NumberFormat('vi-VN').format(product.product_variants[product.product_variants.length - 1]?.price)} VND`
                                    }
                                </td>
                                <td>
                                    ${product.status === 'ACTIVE' 
                                        ? '<span class="badge bg-primary">Hoạt động</span>' 
                                        : '<span class="badge bg-secondary">Vô hiệu hoá</span>'
                                    }
                                </td>
                                <td>${product.category_product ? product.category_product.name : 'Không có danh mục'}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/admin/products/${product.id}/edit" class="btn btn-warning btn-sm mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="/admin/products/${product.id}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `);
                    });

                    // Cập nhật phân trang
                    $('#pagination').html(`
                        <div class="pagination">
                            <div class="page-item ${page === 1 ? 'disabled' : ''}">
                                <span class="page-link" onclick="fetchProducts(${page - 1})">&lt;</span>
                            </div>
                            ${Array.from({ length: response.products.last_page }, (_, i) => `
                                <div class="page-item ${page === i + 1 ? 'active' : ''}">
                                    <span class="page-link" onclick="fetchProducts(${i + 1})">${i + 1}</span>
                                </div>
                            `).join('')}
                            <div class="page-item ${page === response.products.last_page ? 'disabled' : ''}">
                                <span class="page-link" onclick="fetchProducts(${page + 1})">&gt;</span>
                            </div>
                        </div>
                    `);

                    currentPage = page;
                },
                error: function(xhr, status, error) {
                    console.error("Có lỗi xảy ra: ", error);
                }
            });
        }

        // Sự kiện thay đổi bộ lọc
        $('#category-filter, #status-filter').on('change', function() {
            currentPage = 1;
            fetchProducts(currentPage);
        });

        // Sự kiện tìm kiếm
        $('#product-search').on('keyup', function() {
            currentPage = 1;
            fetchProducts(currentPage);
        });

        // Tải danh sách sản phẩm khi trang load
        fetchProducts(currentPage);
    });

</script>
@endpush
