@php
    use Carbon\Carbon;
@endphp

<h1>Thông tin liên hệ mới</h1>
<p><strong>Họ Tên:</strong> {{ $data['ho_ten'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Điện thoại:</strong> {{ $data['dien_thoai'] }}</p>
<p><strong>Nội Dung:</strong> {{ $data['noi_dung'] }}</p>
<p><strong>Thời Gian:</strong> {{ Carbon::parse($data['thoi_gian'])->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</p>


<p>Ban quản trị website MOBICENTER</p>
<p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>


