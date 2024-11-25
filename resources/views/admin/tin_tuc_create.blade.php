@extends('admin/layoutadmin')
@section('title') Thêm tin tức  @endsection
@section('noidungchinh')
<div class="container">
    <h2 class="my-4">Thêm Tin Tức Mới</h2>

    <form action="{{ route('admin.tin_tuc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="tieu_de">Tiêu Đề</label>
            <input type="text" name="tieu_de" class="form-control" id="tieu_de" required>
        </div>

        <div class="form-group">
            <label for="noi_dung">Nội Dung</label>
            <textarea name="noi_dung" class="form-control" id="noi_dung" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="anh">Ảnh</label>
            <input type="file" name="anh" class="form-control" id="anh">
        </div>

        <div class="form-group">
            <label for="ngay_dang">Ngày Đăng</label>
            <input type="date" name="ngay_dang" class="form-control" id="ngay_dang" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Lưu</button>
    </form>
</div>
@endsection
