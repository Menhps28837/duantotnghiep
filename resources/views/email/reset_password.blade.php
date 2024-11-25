@extends('layout')
@section('title') Đặt lại mật khẩu @endsection
@section('noidungchinh')
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
<div class="container mt-3">
    <h1>Đặt Lại Mật Khẩu</h1>
    <form method="POST" action="">
        @csrf
        {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
        <div class="form-group">
            <label style="font-size: 18px" for="email">Địa Chỉ Email</label>
            <input id="email" type="email" class="form-control mt-2 mb-2" name="email" placeholder="Email của bạn" required>
        </div>
        <div class="form-group">
            <label style="font-size: 18px" for="password">Mật Khẩu Mới</label>
            <input id="password" type="password" class="form-control mt-2 mb-2" name="password" required>
        </div>
        <div class="form-group">
            <label style="font-size: 18px" for="confirm_password">Xác Nhận Mật Khẩu</label>
            <input id="confirm_password" type="password" class="form-control mt-2 mb-3" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đặt Lại Mật Khẩu</button>
    </form>
</div>
@endsection
