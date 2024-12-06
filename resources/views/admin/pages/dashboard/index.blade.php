@extends('admin.layouts.master')
@section('title')
    Tổng quan
@endsection
@section('content')
    <div class="animated fadeIn">
        <!-- Widgets  -->
        {{-- <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-cash"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text">$<span class="count">23569</span></div>
                                    <div class="stat-heading">Revenue</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-cart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">3435</span></div>
                                    <div class="stat-heading">Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-browser"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">349</span></div>
                                    <div class="stat-heading">Templates</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">2986</span></div>
                                    <div class="stat-heading">Clients</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Widgets -->

        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-sm-4">
                    <label for="yearSelect">Năm:</label>
                    <select id="yearSelect" class="form-control">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="monthSelect">Tháng:</label>
                    <select id="monthSelect" class="form-control">
                        <option value="">Tất cả</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $i == request('month') ? 'selected' : '' }}>
                                Tháng {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-sm-4">
                    <label for="daySelect">Ngày:</label>
                    <select id="daySelect" class="form-control">
                        <option value="">Tất cả</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ $i == request('day') ? 'selected' : '' }}>
                                Ngày {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-4">
            <div class="row">
                {{-- <div class="col-sm-12 mb-4">
                    <label for="yearSelect">Thống kê theo năm:</label>
                    <select id="yearSelect" class="form-control" style="width: 200px; display: inline-block;">
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                <!-- Phần giao diện của tổng doanh thu -->
                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-1 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1" style="width:220px; z-index:10">
                                <h3 class="fw-r mb-0">
                                    <span>{{ number_format($totalRevenue, 0, ',', '.') }}
                                        <span class="currency mr-1 mt-1" style="font-size: 12px;">VND</span>
                                    </span>
                                </h3>
                                <p class="text-light m-0 mt-1">Tổng Doanh thu</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-6 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1">
                                <h3 class="fw-r mb-0">
                                    <span class="count float-left">{{ $successRate }}</span>
                                    <span>%</span>
                                </h3>
                                <p class="text-light m-0 mt-1" style="width:250px">Tỷ lệ đơn hàng thành công </p>
                            </div><!-- /.card-left -->

                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 pe-7s-cart" style="font-size: 3.68em;"></i>
                            </div><!-- /.card-right -->

                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-3 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1" style="width:220px;z-index: 10">
                                <h3 class="fw-r mb-0">
                                    <span>{{ number_format($totalTodayRevenue, 0, ',', '.') }}<span
                                            class="currency mr-1 mt-1" style="font-size: 12px;">VND</span></span>
                                </h3>
                                <p class="text-light m-0 mt-1" style="width:250px">Doanh thu ngày (hiện tại)</p>
                            </div><!-- /.card-left -->
                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-2 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1">
                                <h3 class="fw-r mb-0">
                                    <span class="count">{{ $newUsers }}</span>
                                </h3>
                                <p class="text-light m-0 mt-1">Người dùng mới</p>
                            </div><!-- /.card-left -->
                            <div class="card-right float-right text-right">
                                <i class="fa fa-user-plus icon fade-5" style="font-size: 3.68em;"></i>
                            </div><!-- /.card-right -->

                        </div>

                    </div>
                </div>
                <!--/.col-->
            </div>
        </div>

        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <a href="{{ route('products.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-four">
                                    <div class="stat-icon me-3">
                                        <i class="fa fa-cubes text-primary fs-3"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="dib text-left">
                                            <div class="stat-heading">Số lượng sản phẩm</div>
                                            <div class="stat-text">Còn hàng: {{ $totalProduct }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-4">
                    <a href="{{ route('orders.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-four">
                                    <div class="stat-icon me-3">
                                        <i class="fa fa-cart-arrow-down text-success fs-3"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="dib text-left">
                                            <div class="stat-heading">Số lượng đơn hàng</div>
                                            <div class="stat-text">Tổng số: {{ $totalOrders }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

                <div class="col-lg-4 col-md-4">
                    <a href="{{ route('feedback.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-four">
                                    <div class="stat-icon me-3">
                                        <i class="fa fa-comments text-warning fs-3"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="dib text-left">
                                            <div class="stat-heading">Số lượng đánh giá</div>
                                            <div class="stat-text">Tổng số: {{ $feedbackCount }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>

        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon me-3">
                                    <i class="fa fa-users text-info fs-3"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">Số lượng khách hàng</div>
                                        <div class="stat-text">Tổng số: {{ $totalUsers }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon me-3">
                                    <i class="fa fa-cubes text-danger fs-3"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">Số lượng sp hết hàng</div>
                                        <div class="stat-text">Tổng số: {{ $totalOutOfStockProducts }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <a href="{{ route('article.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-four">
                                    <div class="stat-icon me-3">
                                        <i class="fa fa-file-text text-secondary fs-3"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="dib text-left">
                                            <div class="stat-heading">Số lượng bài viết</div>
                                            <div class="stat-text">Tổng số: {{ $totalArticles }} </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div>


        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib"><i class="fa fa-usd text-success border-success"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-heading">Đơn hàng thành công</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">

                                    <div class="stat-text">Tổng số: {{ $completedOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib"><i class="fa fa-check text-primary border-primary"
                                            style="font-size: 15px; padding: 5px;"></i></div>
                                    <div class="ml-3">
                                        <div class="stat-heading">Đơn hàng đã giao</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-text">Tổng số: {{ $shippedOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib">
                                        <i class="fa fa-truck text-info border-info"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-heading">Đơn hàng đang giao</div>
                                    </div>
                                </div>

                                <div class="dib mt-1">
                                    <div class="stat-text">Tổng số: {{ $deliveringOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib">
                                        <i class="fa fa-bell text-warning border-warning"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-heading">Đơn hàng chờ xử lý</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-text">Tổng số: {{ $pendingOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib">
                                        <i class="fa fa-times text-danger border-danger"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-heading">Đơn hàng đã hủy</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-text">Tổng số: {{ $cancelledOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <a href="{{ route('refund.index') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-one">
                                    <div class="d-flex align-items-center">
                                        <div class="stat-icon dib"><i
                                                class="fa fa-exclamation-triangle text-dark border-dark"
                                                style="font-size: 15px; padding: 5px;"></i></div>
                                        <div class="ml-3">
                                            <div class="stat-heading">Đơn hàng hoàn trả</div>
                                        </div>
                                    </div>
                                    <div class="dib mt-1">
                                        <div class="stat-text">Tổng số: {{ $refundOrders }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @include('admin.pages.dashboard.components.product-sales-analysis')
        @include('admin.pages.dashboard.components.monthly-revenue-chart')

    </div>
    <script>
        // Lắng nghe sự kiện thay đổi trên các dropdown
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');
        const daySelect = document.getElementById('daySelect');

        function updateURL() {
            const year = yearSelect.value;
            const month = monthSelect.value;
            const day = daySelect.value;

            // Tạo URL mới với các tham số query
            const queryParams = new URLSearchParams();
            if (year) queryParams.set('year', year);
            if (month) queryParams.set('month', month);
            if (day) queryParams.set('day', day);

            window.location.href = `?${queryParams.toString()}`;
        }

        yearSelect.addEventListener('change', updateURL);
        monthSelect.addEventListener('change', updateURL);
        daySelect.addEventListener('change', updateURL);
    </script>
@endsection
