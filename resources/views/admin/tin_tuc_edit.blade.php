@extends('admin/layoutadmin')
@section('title') Chỉnh sửa tin tức  @endsection
@section('noidungchinh')
    <div class="container">
        <h2 class="my-4">Chỉnh Sửa Tin Tức</h2>

        <form action="{{ route('admin.tin_tuc.update', $tinTuc->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tieu_de">Tiêu Đề</label>
                <input type="text" name="tieu_de" class="form-control" id="tieu_de" value="{{ $tinTuc->tieu_de }}" required>
            </div>

            <div class="form-group">
                <label for="noi_dung">Nội Dung</label>
                <textarea name="noi_dung" class="form-control" id="noi_dung" rows="5" required>{{ $tinTuc->noi_dung }}</textarea>
            </div>

            <div class="form-group">
                <label for="anh">Ảnh</label>
                <input type="file" name="anh" class="form-control" id="anh">
                @if($tinTuc->anh)
                    <div class="mt-2">
                        <img src="{{ asset('storage/tin_tuc/' . $tinTuc->anh) }}" class="img-fluid" style="max-width: 150px;">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="ngay_dang">Ngày Đăng</label>
                <input type="date" name="ngay_dang" class="form-control" id="ngay_dang" value="{{ \Carbon\Carbon::parse($tinTuc->ngay_dang)->format('Y-m-d') }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        </form>
    </div>
@endsection
