@extends('admin/layoutadmin')
@section('title') Thêm đơn hàng  @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
<form id="frm" method="post" action="{{route('donhang.store')}}" 
class="m-auto w-10 border border-primary" > @csrf
    <h4 class="m-0 bg-warning p-2 fs-5"> THÊM ĐƠN HÀNG</h4>
    <div class="mb-3 row px-2">
        <div class='col-6'> Tên
            <input name="ten_nguoi_nhan" type="text" class="form-control shadow-none border-primary">
        </div>
        <div class='col-6'> Email
            <input name="email" type="text" class="form-control shadow-none border-primary">
        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6'> Số điện thoại
            <input name="dien_thoai" type="number" class="form-control shadow-none border-primary" >
        </div>
        <div class='col-6'> Địa chỉ
           <input name="dia_chi" type="text" class="form-control shadow-none border-primary" min="1">
        </div>
    </div>
    <div class='col-6 mt-2'>
        <div class='col-12'> 
            <label>Trạng thái :</label>
            <input name="an_hien" type="radio" value="0" checked> Chưa xác nhận
            <input name="an_hien" type="radio" value="1"> Đã xác nhận
        </div>
    </div>
    <div class='mb-3 px-2 mt-3'> 
        <button type="submit" class="btn btn-primary py-2 px-5 border-0"> Lưu database</button>
    </div>
</form>
@endsection
