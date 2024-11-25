<!DOCTYPE html>
<html>
<head>
    <title>Xác Nhận Đơn Hàng</title>
</head>
<body>
    <h1>Cảm ơn bạn đã đặt hàng!</h1>
    <p>Thông tin đơn hàng của bạn:</p>
    <p>ID Đơn Hàng: {{ $order->id }}</p>
    <p>Tên Người Nhận: {{ $order->ten_nguoi_nhan }}</p>
    <p>Email: {{ $order->email }}</p>
    <p>Số Điện Thoại: {{ $order->dien_thoai }}</p>
    <p>Địa Chỉ Giao: {{ $order->dia_chi_giao }}</p>
    <p>Tổng Số Lượng: {{ $order->tong_so_luong }}</p>
    <p>Tổng Tiền: {{ number_format($order->tong_tien, 2) }} VNĐ</p>
    <p>Thời gian đặt hàng: {{date('d/m/Y',strtotime($order->thoi_diem_mua_hang))}}</p>
    <p>Trạng thái: {{$order->loai_thanh_toan==0? "Thanh toán khi nhận hàng":"Chuyển khoản"}} </p>

    <h2>Chi Tiết Sản Phẩm:</h2>
    <table>
        <thead>
            <tr>
                <th>Tên Sản Phẩm</th>
                <th>Hình Ảnh</th>
                <th>Số Lượng</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderDetails as $detail)
                <tr>
                    <td>{{ $detail['ten_sp'] }}</td>
                    <td><img src="{{ asset($detail['hinh']) }}" alt="{{ $detail['ten_sp'] }}" width="100"></td>
                    <td>{{ $detail['so_luong'] }}</td>
                    <td>{{ number_format($detail['gia_km'], 2) }} VNĐ</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <p>Ban quản trị website MOBICENTER</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
