@extends('layout')
@section('title') Liên Hệ @endsection
@section('noidungchinh')
<style>
    .input-error {
        border: 2px solid rgb(132, 134, 246);
    }
</style>
@if (auth()->check())
<div class="container">
    <h2 class="mt-3 text-center">Liên Hệ Chúng Tôi</h2>

    @if(session('thongbao'))
        <div class="alert alert-success">{{ session('thongbao') }}</div>
    @endif

    <form class="m-auto col-10" action="{{ route('lienhe.store') }}" method="POST">
        @csrf
        <div class="form-group mt-3">
            <label for="ho_ten">Họ Tên:</label>
            <input type="text" value="{{old ('ho_ten', Auth::user() ? Auth::user()->name : '')}}" class="form-control" name="ho_ten">
            <b class="text-danger"> @error('ho_ten') {{ $message }} @enderror </b>
        </div>

        <div class="form-group mt-3">
            <label for="email">Email:</label>
            <input type="email" value="{{old ('email', Auth::user() ?Auth::user()->email : '')}}" class="form-control" name="email">
            <b class="text-danger"> @error('email') {{ $message }} @enderror </b>
        </div>
        <div class="form-group mt-3">
            <label for="dien_thoai">Điện thoại:</label>
            <input type="text" value="{{old ('dien_thoai', Auth::user() ?Auth::user()->dien_thoai : '')}}" class="form-control" name="dien_thoai">
            <b class="text-danger"> @error('dien_thoai') {{ $message }} @enderror </b>
        </div>

        <div class="form-group mt-3">
            <label for="noi_dung">Nội Dung:</label>
            <textarea class="form-control {{ $errors->has('noi_dung') ? 'input-error' : '' }}" value="{{old('noi_dung')}}" name="noi_dung" rows="5"></textarea>
            <b class="text-danger"> @error('noi_dung') {{ $message }} @enderror </b>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Gửi</button>
    </form>
</div>
@else 
<div class="container">
    <h2 class="mt-3 text-center">Liên Hệ Với Chúng Tôi</h2>

    @if(session('thongbao'))
        <div class="alert alert-success">{{ session('thongbao') }}</div>
    @endif

    <form class="m-auto col-10" action="{{ route('lienhe.store') }}" method="POST">
        @csrf
        <div class="form-group mt-3">
            <label for="ho_ten">Họ Tên:</label>
            <input type="text" value="{{old('ho_ten')}}" class="form-control {{ $errors->has('ho_ten') ? 'input-error' : '' }}" name="ho_ten">
            <b class="text-danger"> @error('ho_ten') {{ $message }} @enderror </b>
        </div>

        <div class="form-group mt-3">
            <label for="email">Email:</label>
            <input type="email" value="{{old('email')}}" class="form-control {{ $errors->has('email') ? 'input-error' : '' }}" name="email">
            <b class="text-danger"> @error('email') {{ $message }} @enderror </b>
        </div>

        <div class="form-group mt-3">
            <label for="dien_thoai">Điện thoại:</label>
            <input type="text" value="{{old('dien_thoai')}}" class="form-control {{ $errors->has('dien_thoai') ? 'input-error' : '' }}" name="dien_thoai">
            <b class="text-danger"> @error('dien_thoai') {{ $message }} @enderror </b>
        </div>

        <div class="form-group mt-3">
            <label for="noi_dung">Nội Dung:</label>
            <textarea class="form-control {{ $errors->has('noi_dung') ? 'input-error' : '' }}" name="noi_dung" rows="5">{{ old('noi_dung') }}</textarea>
            <b class="text-danger"> @error('noi_dung') {{ $message }} @enderror </b>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Gửi liên hệ</button>
    </form>
</div>
@endif


@endsection
