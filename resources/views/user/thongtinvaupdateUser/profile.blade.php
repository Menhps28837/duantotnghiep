@extends('layout')
@section('title') Profile @endsection
@section('noidungchinh')
    <div class="row mt-3">
        <h1 class="text-center">Thông tin người dùng</h1>
        <hr>
        @if(session()->has('success'))
        <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
            {!! session('success') !!}
        </div>
    @endif
        <div class="row m-auto fs-4">
            <p class="fs-1"> {{ $user->name }}</p>
            <div class="col-6">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Điện thoại:</strong> {{ $user->dien_thoai }}</p>
            </div>
            <div class="col-6">
                {{-- @if($user->hinh)
                    <img src="{{ asset('storage/' . $user->hinh) }}" alt="Hình ảnh người dùng" />
                @endif --}}
            {{-- </div> --}}
            {{-- <div class="col-6"> --}}
                <p><strong>Địa chỉ:</strong> {{ $user->dia_chi }}</p>
                <p><strong>Thời gian tạo:</strong> {{date('d/m/Y',strtotime($user->created_at))}}</p>
            </div>
        </div>
    </div>
    <div style="margin-left: 10px">
        <a href="{{ url('/user/' . $user->id . '/edit') }}" class="btn btn-secondary">Chỉnh sửa thông tin</a>
    </div>
@endsection
