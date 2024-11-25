<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận giao hàng</title>
</head>
<body>
    <h1>Xin chào {{ $order->ten_nguoi_nhan }}</h1>
    <p>Cảm ơn bạn đã xác nhận rằng bạn đã nhận được đơn hàng.</p>
    <p>Thông tin đơn hàng:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->id }}</li>
        <li>Địa chỉ giao hàng: {{ $order->dia_chi_giao }}</li>
        <li>Điện thoại: {{ $order->dien_thoai }}</li>
    </ul>
    <p>Ban quản trị website MOBICENTER</p>
    <p>Chúng tôi hy vọng bạn hài lòng với sản phẩm của mình!</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
