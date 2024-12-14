@extends('admin.layouts.master')
@section('title')
    Danh sách đơn hoàn
@endsection
@section('content')
    <div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách đơn hoàn</strong>
                </div>
                <div class="card-body">
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Mã đơn hoàn </th>
                                <th class="text-center" scope="col">Giá trị đơn hoàn hàng</th>
                                <th class="text-center" scope="col">Khách hàng</th>
                                <th class="text-center" scope="col">Liên hệ</th>
                                <th class="text-center" scope="col">Trạng thái</th>
                                <th class="text-center" scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refunds as $refund)
                                <tr>
                                    <td scope="row" class="text-center">
                                        {{ $refund->code ?? 'Không có mã đơn hoàn hàng' }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($refund->refund_total_amount, 0, ',', '.') }} VND</td>
                                    <td class="text-center"> {{ $refund->order->customer_name }}</td>
                                    <td class="text-center">{{ $refund->order->phone }}</td>
                                    <td class="text-center">
                                        @php
                                            $statusText = '';
                                            $statusClass = '';
                                            switch ($refund->status) {
                                                case 'PENDING':
                                                    $statusText = 'Đang chờ phê duyệt';
                                                    $statusClass = 'badge bg-warning';
                                                    break;
                                                case 'APPROVED':
                                                    $statusText = 'Đã được phê duyệt';
                                                    $statusClass = 'badge bg-success';
                                                    break;
                                                case 'IN_TRANSIT':
                                                    $statusText = 'Đang vận chuyển';
                                                    $statusClass = 'badge bg-primary';
                                                    break;
                                                case 'COMPLETED':
                                                    $statusText = 'Hoàn tất';
                                                    $statusClass = 'badge bg-success';
                                                    break;
                                            }
                                        @endphp
                                        <span class="{{ $statusClass }}">{{ $statusText }}</span>
                                    </td>

                                    <td class="text-center">
                                        <a class="btn btn-primary" href="{{ route('refund.edit', $refund->id) }}">Cập nhật
                                            trạng thái</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $refunds->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
