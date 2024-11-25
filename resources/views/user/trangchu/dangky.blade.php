@extends('layout')
@section('title') Đăng ký thành viên @endsection
@section('noidungchinh')
<h2 class="text-center mt-5 ">ĐĂNG KÝ THÀNH VIÊN</h2>
<style>
    .input-error { 
        border: 2px solid rgb(132, 134, 246);
    }
</style>
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
<div class="row col-10 m-auto shadow-lg">
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center py-5"
        style="background: linear-gradient(135deg, #000000, #FFFFFF);
               color: #000000; border-radius: 10px;">
        <img style="width: 70%" src="/images/Logo.jpg" alt="Logo" class="welcome-logo img-fluid mb-3">
        <h2>Xin Chào!</h2>
        <p>Để giữ liên lạc với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
    </div>


    <div class="col-md-6 bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <form method="post" action="{{url('/dangky')}}" class="m-auto col-10 p-2 mt-3 fs-5"> @csrf
            <div class="col-12"> Email
                <input name="email" value="{{old('email')}}" type="text" class="form-control shadow-none {{ $errors->has('email') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('email') {{ $message }} @enderror </b>
            </div>
            <div class="col-12"> Điện thoại
                <input name="dien_thoai" value="{{old('dien_thoai')}}" type="text" class="form-control shadow-none {{ $errors->has('dien_thoai') ? 'input-error' : '' }}">
                <b style="font-size:     15px" class="text-danger"> @error('dien_thoai') {{ $message }} @enderror </b>
            </div>
            <div class="col-12">Họ tên
                <input name="name" value="{{old('name')}}" type="text" class="form-control shadow-none {{ $errors->has('name') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('name') {{ $message }} @enderror </b>
            </div>
            <div class="col-12"> Mật khẩu
                <input name="mk1" value="{{old('mk1')}}" type="password" class="form-control shadow-none {{ $errors->has('mk1') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('mk1') {{ $message }} @enderror </b>
            </div>
            <div class="col-12"> Nhập lại mật khẩu
                <input name="mk2" value="{{old('mk2')}}" type="password" class="form-control shadow-none {{ $errors->has('mk2') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('mk2') {{ $message }} @enderror </b>
            </div>
            <div class="col-12"> Địa chỉ
                <input name="dia_chi" value="{{old('dia_chi')}}" type="text" class="form-control shadow-none {{ $errors->has('dia_chi') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('dia_chi') {{ $message }} @enderror </b>
            </div>            
            <div class="mt-3">
                <div><button class="btn btn-primary py-2 px-5 fs-5 col-12" type="submit">Đăng ký</button></div>
            </div>
            <div class="text-center mt-3">
                <span style="color: rgb(100, 100, 100); font-size: 16px">Bạn đã có tài khoản? <a
                        style="color: red; font-weight: bold" href="{{url('/admin/dangnhap')}}">Đăng nhập ngay</a>
                </span>
            </div>
            <div class="line-through is-flex is-align-items-center" style="gap: 10px;margin: 20px auto 0; width: 60%;">
                <hr background-color: #dbdbdb; width: 100%;>
                <p class="text-center">Hoặc</p>
            </div>
            <div id="dngooggle" class="text-center mt-3">
                <a href="{{url('/login/google')}}">
                    <img width="32" src="/images/google.png"> Google
                </a>
            </div>
        </form>
    </div>
</div>
@endsection