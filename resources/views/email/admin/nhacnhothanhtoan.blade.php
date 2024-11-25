<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu chuyển khoản lại</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007BFF;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông báo yêu cầu chuyển khoản</h2>
        <p>Chào {{ $order->ten_nguoi_nhan }},</p>
        <p>Chúng tôi xin thông báo rằng đơn hàng của bạn với mã số <strong>{{ $order->id }}</strong> cần thanh toán lại.</p>
        <p><strong>Số tiền cần thanh toán:</strong> {{ number_format($order->tong_tien, 0, ",", ".") }} VNĐ</p>
        <p>Xin vui lòng thực hiện chuyển khoản vào tài khoản dưới đây:</p>
        <ul>
            <li><strong>Tên ngân hàng:</strong> Ngân hàng ABC</li>
            <li><strong>Số tài khoản:</strong> 123456789</li>
            <li><strong>Chủ tài khoản:</strong> Ban quản trị website TheGioiDiDong</li>
        </ul>
        <p>Ban quản trị website MOBICENTER</p>
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    </div>
    <div class="footer">
        <p>Địa chỉ: Đường Tx33, Phường Thạnh Xuân, Thành phố Hồ Chí Minh</p>
        <p>Email: tieuanhcuong2004@gmail.com | Điện thoại: 0909 187 402</p>
    </div>
</body>
</html>
