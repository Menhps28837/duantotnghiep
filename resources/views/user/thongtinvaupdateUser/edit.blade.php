{{-- resources/views/user/edit.blade.php --}}
@extends('layout')
@section('title') Chỉnh sửa thông tin @endsection
@section('noidungchinh')
    <h1>Chỉnh sửa thông tin người dùng</h1>
    <style>
        .input-error { 
            border: 2px solid rgb(132, 134, 246);
        }
    </style>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('khuser.update', $user->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên:</label>
            <input name="name" value="{{ $user->name }}" type="text" class="form-control shadow-none {{ $errors->has('name') ? 'input-error' : '' }}">
            <b style="font-size: 15px" class="text-danger"> @error('name') {{ $message }} @enderror </b>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input name="email" value="{{ $user->email }}" type="text" class="form-control shadow-none {{ $errors->has('email') ? 'input-error' : '' }}">
            <b style="font-size: 15px" class="text-danger"> @error('email') {{ $message }} @enderror </b>
        </div>
        <div class="mb-3">
            <label for="dien_thoai" class="form-label">Điện thoại:</label>
            <input name="dien_thoai" value="{{ $user->dien_thoai }}" type="text" class="form-control shadow-none {{ $errors->has('dien_thoai') ? 'input-error' : '' }}">
            <b style="font-size: 15px" class="text-danger"> @error('dien_thoai') {{ $message }} @enderror </b>
        </div>
        <div class="mb-3">
            <label for="dia_chi" class="form-label">Địa chỉ:</label>
            <input name="dia_chi" value="{{ $user->dia_chi }}" type="text" class="form-control shadow-none {{ $errors->has('dia_chi') ? 'input-error' : '' }}">
            <b style="font-size: 15px" class="text-danger"> @error('dia_chi') {{ $message }} @enderror </b>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('khuser.profile', $user->id) }}" class="btn btn-secondary">Quay lại</a>
    </form> 
@endsection 

