@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title"> Danh sách đơn hàng</strong>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Người dùng</th>
                            <th scope="col">Tổng</th>
                            <th scope="col">Phương thức thanh toán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $order)
                            <tr class="">
                                <td scope="row">{{ $order->id }}</td>
                                <td>{{ $order->addressUser->user->full_name }}</td>
                                <td>{{ $order->discount_amount }}</td>
                                <td>
                                    @if ($order->payment_method == 'CASH')
                                        <span class="badge bg-info">Cod</span>
                                    @else
                                        <span class="badge bg-info">Online</span>
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
                                        <span class="badge bg-success">Đơn hàng hoàn tất.</span>
                                    @elseif ($order->status === 'CANCELED')
                                        <span class="badge bg-danger">Đơn hàng đã Huỷ</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at }}</td>
                                <td>
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Cập nhật
                                        trạng thái</a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

            {{ $data->links() }}
        </div>
    </div>
@endsection
