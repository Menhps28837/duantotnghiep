@extends('layout')
@section('title') Quên mật khẩu @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
<div class="container mt-3">
    <h1>Quên Mật Khẩu</h1>
    <form method="POST" action="">
        @csrf
        <div class="form-group">
            <label style="font-size: 18px" for="email">Địa Chỉ Email</label>
            <input id="email" type="email" class="form-control mt-2 mb-3" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Gửi Đường Dẫn Đặt Lại Mật Khẩu</button>
    </form>
</div>
@endsection
