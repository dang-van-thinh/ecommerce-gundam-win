<!DOCTYPE html>
<html>
<head>
    <title>Nhắc nhở đơn hàng</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; color: #333;">
    <h1>Xin chào {{ $userName }},</h1>
    <p>Đơn hàng #{{ $code }} của bạn vẫn đang trong trạng thái xử lý. Hãy thanh toán để chúng tôi có thể giao hàng cho bạn sớm nhất!</p>
    <a href="{{ url('/profile/order', $orderId) }}" style="background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Xem chi tiết đơn hàng</a>
</body>
</html>
