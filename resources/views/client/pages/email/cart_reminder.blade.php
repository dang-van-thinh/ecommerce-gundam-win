<!DOCTYPE html>
<html>
<head>
    <title>Nhắc nhở giỏ hàng</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f7f7f7; color: #333;">
    <table align="center" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; background-color: #ffffff; margin: 20px auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
        <!-- Header -->
        <tr>
            <td style="background-color: #007bff; color: #ffffff; padding: 20px; text-align: center;">
                <h1 style="margin: 0; font-size: 24px;">Nhắc nhở giỏ hàng</h1>
            </td>
        </tr>
        <!-- Body -->
        <tr>
            <td style="padding: 20px;">
                <h2 style="margin-top: 0; font-size: 20px;">Xin chào {{ $userName }},</h2>
                <p style="font-size: 16px; line-height: 1.6;">Bạn có giỏ hàng đã bỏ quên trong 3 ngày qua. Hãy hoàn tất đơn hàng của bạn để không bỏ lỡ sản phẩm yêu thích!</p>
                <div style="text-align: center; margin: 20px 0;">
                    <a href="{{ route('cart') }}" style="background-color: #007bff; color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; display: inline-block;">Quay lại giỏ hàng</a>
                </div>
                <p style="font-size: 14px; color: #555;">Nếu bạn không quan tâm đến giỏ hàng này, vui lòng bỏ qua email này.</p>
            </td>
        </tr>
        <!-- Footer -->
        <tr>
            <td style="background-color: #f1f1f1; text-align: center; padding: 10px; font-size: 14px; color: #777;">
                <p style="margin: 0;">© 2024 Cửa hàng của bạn. Tất cả các quyền được bảo lưu.</p>
            </td>
        </tr>
    </table>
</body>
</html>
