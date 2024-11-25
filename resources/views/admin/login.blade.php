@extends('layout')
@section('title') Đăng nhập @endsection
@section('noidungchinh')
<h1 class="text-center mt-3">Đăng nhập</h1>
<style>
    .input-error {
        border: 2px solid rgb(132, 134, 246);
    }
</style>
<div class="row col-10 m-auto shadow-lg">
    <div class="col-md-6 d-flex flex-column justify-content-center align-items-center text-center py-5" style="background: linear-gradient(135deg, #000000, #FFFFFF);
               color: #000000; border-radius: 10px;">
        <img style="width: 70%" src="/images/Logo.jpg" alt="Logo" class="welcome-logo img-fluid mb-3">
        <h2>Xin Chào!</h2>
        <p>Để giữ liên lạc với chúng tôi, vui lòng đăng nhập bằng thông tin cá nhân của bạn</p>
    </div>

    <div class="col-md-6 bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <form action="{{url('admin/dangnhap')}}" method="post" class="m-auto col-10 p-3 mt-3 fs-5">@csrf
            @if(session()->has('thongbao'))
                <div class="alert alert-danger p-2 mx-auto my-3 col-10 fs-5 text-center">
                    {!! session('thongbao') !!}
                </div>
            @endif
            @if(session()->has('thongbao2'))
                <div class="alert alert-success p-2 mx-auto my-3 col-10 fs-5 text-center">
                    {!! session('thongbao2') !!}
                </div>
            @endif
            <div class='mb-3'> <label> Email</label>
                <input name="email" value="{{old('email')}}" type="text"
                    class="form-control shadow-none {{ $errors->has('email') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('email') {{ $message }} @enderror </b>
            </div>
            <div class='mb-3'> <label> Mật khẩu</label>
                <input name="password" value="{{old('password')}}" type="password"
                    class="form-control shadow-none {{ $errors->has('password') ? 'input-error' : '' }}">
                <b style="font-size: 15px" class="text-danger"> @error('password') {{ $message }} @enderror </b>
            </div>
            <div class="text-end">
                <p><a style="color: rgb(100, 100, 100); font-size: 14px" href="/forgot-password">Quên mật khẩu?</a></p>
            </div>
            <div>
                <button type="submit" style="font-weight: bold; font-size: 20px"
                    class="btn btn-primary py-2 px-5 border-0 col-12">Đăng nhập</button>
            </div>
            <div class="text-center mt-3">
                <span style="color: rgb(100, 100, 100); font-size: 16px">Bạn chưa có tài khoản? <a
                        style="color: red; font-weight: bold" href="{{url('/dangky')}}">Đăng kí ngay</a> </span>
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