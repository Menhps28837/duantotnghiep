@extends('layout')
@section('title') Đăng ký thành viên @endsection
@section('noidungchinh')
    <div class="alert alert-info text-center">
    @if(Session::exists('thongbao'))
        <h4>{{ Session::get('thongbao') }}</h4> <hr>
        @endif
        <p>Cảm ơn quý khách đã đăng ký</p>
    <a href="/">Trở về trang chủ</a>
    </div>
@endsection 