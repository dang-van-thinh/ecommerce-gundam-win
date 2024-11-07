@foreach ($orders as $order)
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
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Cập nhật trạng thái</a>
        </td>
    </tr>
@endforeach
