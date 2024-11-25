@extends('admin.layoutadmin')
@section('title', 'Quản lý liên hệ')
@section('noidungchinh')
<h4 class="bg-gradient-dark text-white fw-bolder p-2">QUẢN LÝ LIÊN HỆ</h4>

@if($lienHe->count() === 0 && request('search'))
    <div class="alert alert-warning">Không tìm thấy liên hệ nào với từ khóa "{{ request('search') }}".</div>
@endif

@if (session('thongbao'))
    <div class="alert alert-success">{{ session('thongbao') }}</div>
@endif

<form method="GET" action="{{ route('admin.lienhe') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc email..." value="{{ request('search') }}">
        <div class="input-group-append">
            <button class="btn btn-secondary" type="button" onclick="clearSearch()">x</button>
            <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </div>
</form>

<script>
    function clearSearch() {
        document.querySelector('input[name="search"]').value = ''; 
        document.querySelector('form').submit(); 
    }
</script>

@if($lienHe->count() === 0 && !request('search'))
    <div class="alert alert-info">Chưa có liên hệ nào.</div>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 180px">Họ Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th style="width: 600px">Nội Dung</th>
                <th class="text-center" style="width: 150px">Thời Gian</th>
                <th class="text-center" style="width: 160px">Xóa và Trả Lời</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lienHe as $lh)
                <tr>
                    <td>{{ $lh->ho_ten }}</td>
                    <td>{{ $lh->email }}</td>
                    <td>{{ $lh->dien_thoai }}</td>
                    <td>{{ $lh->noi_dung }}
                        @if ($lh->thoi_gian >= $thoiGianMoi)
                            <span class="badge bg-info">Mới</span>
                        @endif
                    </td>
                    <td class="text-center">{{date('d/m/Y',strtotime($lh->thoi_gian))}}</td>
                    <td class="text-center">
                        <form action="{{ route('lienhe.destroy', $lh->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type='submit' onclick="return confirm('Xác nhận xóa')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>

                        <button class="btn btn-primary btn-sm" onclick="toggleReplyForm({{ $lh->id }})">Trả lời</button>

                        <form id="reply-form-{{ $lh->id }}" action="{{ route('lienhe.traloi', $lh->id) }}" method="POST" style="display:none;">
                            @csrf
                            <input style="width: 120px" class="mt-3 mb-3" type="text" name="noi_dung" placeholder="Nhập trả lời" required>
                            <button type='submit' class="btn btn-success btn-sm">Gửi</button>
                            <button type='button' class="btn btn-secondary btn-sm" onclick="toggleReplyForm({{ $lh->id }})">Hủy</button>
                        </form>
                        <script>
                            function toggleReplyForm(id) {
                                const form = document.getElementById(`reply-form-${id}`);
                                form.style.display = (form.style.display === "none") ? "block" : "none";
                            }
                        </script>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-2 d-flex justify-content-center">{{$lienHe->links() }}</div>
@endif
@endsection
