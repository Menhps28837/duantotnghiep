<!DOCTYPE html>
<html>
<head>
    <title>Yêu cầu trả hàng đã được chấp nhận</title>
</head>
<body>
    <h1>Xin chào {{ $donHang->ten_nguoi_nhan }},</h1>
    <p>Chúng tôi xin thông báo rằng yêu cầu trả lại đơn hàng của bạn (ID: {{ $donHang->id }}) đã được chấp nhận.</p>
    <p>Trong 2-3 ngày sau chúng tôi sẽ cho shipper xuống lấy lại hàng và trả tiền lại cho bạn.</p>
    <p>Ban quản trị website MOBICENTER</p>
    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
