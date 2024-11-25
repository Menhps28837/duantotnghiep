<!DOCTYPE html>
<html>
<head>
    <title>Thông báo giao hàng</title>
</head>
<body>
    <h1>Xin chào {{ $order->ten_nguoi_nhan }}</h1>
    <p>Đơn hàng của bạn đã được giao cho shipper.</p>
    <p>Thông tin đơn hàng:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->id }}</li>
        <li>Địa chỉ giao hàng: {{ $order->dia_chi_giao }}</li>
        <li>Điện thoại: {{ $order->dien_thoai }}</li>
        <li>Trạng thái: Đang giao hàng</li>
        <li>Thanh toán: {{$order->loai_thanh_toan==0? "Thanh toán khi nhận hàng":"Chuyển khoản"}}</li>
    </ul>
    {{-- <a href="{{ route('order.confirm_received', ['id' => $order->id]) }}" style="padding: 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">Xác nhận đã nhận hàng</a> --}}

    <p>Ban quản trị website MOBICENTER</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>

</body>
</html>
