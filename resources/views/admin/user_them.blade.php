@extends('admin/layoutadmin')
@section('title') Thêm user  @endsection
@section('noidungchinh')
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
<form id="frm" method="post" action="{{route('user.store')}}" 
class="m-auto w-10 border border-primary" > @csrf
    <h4 class="m-0 bg-gradient-dark text-white p-2 fs-5"> THÊM USER</h4>
    <div class="mb-3 row px-2">
        <div class='col-6'> Tên
            <input name="name" value="{{old('name')}}" type="text" class="form-control shadow-none border-primary">
        <b class="text-danger"> @error('name') {{ $message }} @enderror </b>

        </div>
        <div class='col-6'> Email
            <input name="email" value="{{old('email')}}" type="text" class="form-control shadow-none border-primary">
        <b class="text-danger"> @error('email') {{ $message }} @enderror </b>

        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6'> Password
            <input name="mk1" value="{{old('mk1')}}"  type="password" class="form-control shadow-none border-primary" >
        <b class="text-danger"> @error('mk1') {{ $message }} @enderror </b>

        </div>
        <div class='col-6'> Số điện thoại
            <input name="dien_thoai" value="{{old('dien_thoai')}}" type="number" class="form-control shadow-none border-primary" >
        <b class="text-danger"> @error('dien_thoai') {{ $message }} @enderror </b>

        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6'> Địa chỉ
            <input name="dia_chi" value="{{old('dia_chi')}}" type="text" class="form-control shadow-none border-primary">
        <b class="text-danger"> @error('dia_chi') {{ $message }} @enderror </b>

         </div>
         <div class='col-6 mt-4'> 
            <label>Phân loại :</label>
            <input name="role" type="radio" value="0" checked> User
            <input name="role" type="radio" value="1"> Admin
        </div>
    </div>
{{--   
    <div class='col-6 mt-2'>
        <div class='col-12'> 
            <label>Trạng thái :</label>
            <input name="role" type="radio" value="0" checked> User
            <input name="role" type="radio" value="1"> Admin
        </div>
    </div> --}}
    <div class='mb-3 px-2 mt-3'> 
        <button type="submit" class="btn btn-dark py-2 px-5 border-0">Thêm user mới</button>
    </div>
</form>
@endsection
