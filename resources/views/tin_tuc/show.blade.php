@extends('layout')
@section('title') Tin tức chi tiết @endsection
@section('noidungchinh')
    <div class="container ">
        <h2 class="my-4">{{ $tinTuc->tieu_de }}</h2>
        <p class="text-muted">Ngày đăng: {{date('d/m/Y',strtotime($tinTuc->ngay_dang))}}</p>
        <img src="{{ asset('storage/tin_tuc/' . $tinTuc->anh) }}" class="img-fluid responsive-img" alt="{{ $tinTuc->tieu_de }}">
        <p class="mt-4">{!! $tinTuc->noi_dung !!}</p>
        <a href="{{ route('tin_tucs.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
<style>
  .mt-4 img {
    width: 80%; /* Đặt chiều rộng hình ảnh theo tỷ lệ phần trăm */
    height: auto; /* Giữ tỷ lệ gốc của hình ảnh */
}

@media (max-width: 767px) {
    .mt-4 img {
        width: 100%; /* Đặt chiều rộng hình ảnh 100% trên mobile */
        height: auto; /* Giữ tỷ lệ gốc */
    }
}

</style>

@endsection
