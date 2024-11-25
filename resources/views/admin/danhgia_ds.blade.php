@extends('admin/layoutadmin')
@section('title') Danh sách đánh giá @endsection
@section('noidungchinh')
<div class="container">
    <h1>Quản lý Đánh giá</h1>

    <!-- Hiển thị thông báo nếu có -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Người dùng</th>
                <th>ID đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Nhận xét</th>
                <th>Ngày đánh giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
            <tr>
                <td>{{ $review->user->name ?? 'Người dùng không xác định' }}</td>
                <td>{{ $review->id_dh ?? 'Người dùng không xác định' }}</td>
                <td>{{ $review->product->ten_sp ?? 'Sản phẩm không xác định' }}</td>
                <td>
                    @if ($review->rating == 0)
                        Tốt
                    @elseif ($review->rating == 1)
                        Trung bình
                    @elseif ($review->rating == 2)
                        Không tốt
                    @endif
                </td>
                <td>{{ $review->comment }}
                    @if ($review->created_at >= $thoiGianMoi)
                            <span style="font-size: 12px" class="badge bg-info">Mới</span> 
                        @endif
                </td>
                <td> {{date('d/m/Y',strtotime($review->created_at))}}</td>
                <td>
                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-dark">Sửa</a>
                    <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
