<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu trả hàng</title>
</head>
<body>
    <h1>Xin chào {{ $tenKhachHang }},</h1>
    <p>Bạn vừa gửi yêu cầu trả hàng cho đơn hàng ID: {{ $donHang->id }}.</p>
    
    <strong>Lý do trả hàng:</strong>
    <ul>
        @if (!empty($reasons))
            @foreach ($reasons as $reason)
                <li>{{ $reason }}</li>
            @endforeach
        @else
            <li>Không có lý do cụ thể</li>
        @endif
    </ul>
    
    <strong>Chi tiết lý do:</strong> {{ $lydo }}
    
    <p>Trạng thái: {{ $trangThai }}</p>
    <p>Ban quản trị website MOBICENTER sẽ xem xét yêu cầu của bạn.</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
