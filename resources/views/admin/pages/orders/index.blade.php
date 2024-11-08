@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách đơn hàng</strong>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-9">
                </div>
                <div class="col-md-3">
                    <select class="form-select" onchange="window.location.href = '?status=' + this.value;">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Chọn tất cả</option>
                        <option value="PENDING" {{ $status == 'PENDING' ? 'selected' : '' }}>Đang chờ xử lý</option>
                        <option value="DELIVERING" {{ $status == 'DELIVERING' ? 'selected' : '' }}>Đang giao hàng</option>
                        <option value="SHIPPED" {{ $status == 'SHIPPED' ? 'selected' : '' }}>Đã giao hàng</option>
                        <option value="COMPLETED" {{ $status == 'COMPLETED' ? 'selected' : '' }}>Đơn hàng hoàn tất</option>
                        <option value="CANCELED" {{ $status == 'CANCELED' ? 'selected' : '' }}>Đơn hàng đã Huỷ</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Người dùng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Phương thức thanh toán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="orderData">
                        @foreach ($data as $order)
                            <tr class="">
                                <td scope="row">{{ $order->code }}</td>
                                <td>{{ $order->user->full_name }}</td>
                                <td>{{ number_format($order->total_amount) }}VND</td>
                                <td>
                                    @if ($order->payment_method == 'CASH')
                                        <span class="badge bg-info">Thanh toán khi nhận hàng</span>
                                    @else
                                        <span class="badge bg-info">Thanh toán Online</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 'PENDING')
                                        <span class="badge bg-warning">Đang chờ xử lý</span>
                                    @elseif ($order->status === 'DELIVERING')
                                        <span class="badge bg-primary">Đang giao hàng</span>
                                    @elseif ($order->status === 'SHIPPED')
                                        <span class="badge bg-primary">Đã giao hàng</span>
                                    @elseif ($order->status == 'COMPLETED')
                                        <span class="badge bg-success">Đơn hàng hoàn tất</span>
                                    @elseif ($order->status === 'CANCELED')
                                        <span class="badge bg-danger">Đơn hàng đã Huỷ</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Cập
                                        nhật
                                        trạng thái</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
