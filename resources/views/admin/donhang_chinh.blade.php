@extends('admin/layoutadmin')
@section('title') Sửa đơn hàng  @endsection
@section('noidungchinh')
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
    <form id="frm" method="post" action="{{route('donhang.update', $donhang->id )}}" class="m-auto w-10 border border-primary">
        @csrf
        @method('PUT')
        <h4 class="m-0 bg-gradient-dark text-white p-2 fs-5"> CHỈNH ĐƠN HÀNG</h4>
        <div class="mb-3 row px-2">
            <div class='col-6'> Tên 
                <input name="ten_nguoi_nhan" type="text" value="{{$donhang->ten_nguoi_nhan}}" 
                class="form-control shadow-none border-primary">
            </div>
            <div class='col-6'> Email
                <input name="email" type="text" value="{{$donhang->email}}" 
                class="form-control shadow-none border-primary">
            </div>
        </div>
        <div class="mb-3 row px-2">
            <div class='col-6'> Số điện thoại
                <input name="dien_thoai" type="number" value="{{$donhang->dien_thoai}}"
                class="form-control shadow-none border-primary" >
            </div>
            <div class='col-6'> Địa chỉ  
                <input name="dia_chi_giao" type="text" value="{{$donhang->dia_chi_giao}}"
                class="form-control shadow-none border-primary" min="1">
            </div>
        </div>
        {{-- <div class='col-5 text-center'> 
            <div class='col-8'> 
                <label> Trạng thái :</label>
                <input name="trang_thai" type="radio" value="0" {{$donhang->trang_thai==0? "checked":""}} > Chưa xác nhận 
                <input name="trang_thai" type="radio" value="1" {{$donhang->trang_thai==1? "checked":""}} > Đã xác nhận
            </div>
        </div> --}}
        <div class='mb-3 px-2 mt-3'> 
            <button type="submit" class="btn btn-dark py-2 px-5 border-0"> Sửa đơn hàng</button>
        </div>



        {{-- <label for="order_number">Order Number:</label>
        <input type="text" name="order_number" id="order_number" value="{{ $order->order_number }}" required>
        
        <label for="total_amount">Total Amount:</label>
        <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ $order->total_amount }}" required>
        
        <label for="status">Status:</label>
        <input type="text" name="status" id="status" value="{{ $order->status }}" required>
        
        <button type="submit">Update Order</button> --}}
    </form>
@endsection
