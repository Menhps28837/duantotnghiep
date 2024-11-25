<!DOCTYPE html>
<html>
<head>
    <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
    <h1>Cảm ơn bạn đã đặt hàng!</h1>
    <p>Chúng tôi đã nhận được đơn hàng của bạn với thông tin như sau:</p>
    <p><strong>Mã đơn hàng:</strong> {{ $donHang->id }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tong_tien, 0, ',', '.') }} VNĐ</p>
    <p>Trạng thái: Đơn hàng đã được xác nhận</p>
    <p>Ban quản trị website MOBICENTER</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
