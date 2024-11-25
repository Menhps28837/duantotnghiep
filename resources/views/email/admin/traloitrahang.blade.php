<h1>Xin chào {{ $tenKhachHang }},</h1>
<p>Chúng tôi có câu hỏi về yêu cầu trả hàng của bạn:</p>
<p>{{ $cauHoi }}</p>
<p>ID đơn hàng: {{ $idDonHang }}</p>
<p>Lý do trả hàng:</p>
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
<p>Vui lòng phản hồi lại để chúng tôi có thể hỗ trợ bạn tốt hơn.</p>
<p>Ban quản trị website MOBICENTER</p>
<p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
