@extends('admin/layoutadmin')
@section('title') Thêm sản phẩm  @endsection
@section('noidungchinh')
<form id="frm" method="post" action="{{route('sanpham.store')}}" 
enctype="multipart/form-data" class="m-auto w-10 border border-primary" > @csrf
    <h4 class="m-0 bg-gradient-dark text-white p-2 fs-5"> THÊM SẢN PHẨM</h4>
    <div class="mb-3 row px-2">
        <div class='col-6'> Tên sản phẩm 
            <input name="ten_sp" type="text" class="form-control shadow-none border-primary">
        </div>
        <div class='col-6'> Ngày 
            <input name="ngay" type="date" class="form-control shadow-none border-primary" >
        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6'> Giá  
           <input name="gia" type="number" class="form-control shadow-none border-primary" min="1">
        </div>
        <div class='col-6'> Giá km
         <input name="gia_km" type="number" class="form-control shadow-none border-primary" min="1">
        </div>
    </div>
    <div class="mb-3 row px-2">    
        <div class='col-6'> 
            <select name="id_loai" class="form-control shadow-none border-primary">
                <option value="-1">Chọn loại</option>
                @foreach( $loai_arr as $loai)
                <option value="{{$loai->id}}">{{$loai->ten_loai}}</option>
                @endforeach
            </select>
        </div>   
        <div class='col-6'>
            <select name="tinh_chat" class="form-control shadow-none border-primary">
                <option value="0">Tính chất</option>
                <option value="0">Bình thường</option>
                <option value="1">Giá rẻ</option>
                <option value="2">Giảm sốc</option>
                <option value="3">Cao cấp</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6 p-2 pl-2'> 
            <input name="hinh" type="text" placeholder="Hình sản phẩm"
            class="form-control shadow-none border-primary">

        </div>  
        <div class='col-2 pt-3'> 
            <input name="an_hien" type="radio" value="0"> Ẩn
            <input name="an_hien" type="radio" value="1" checked> Hiện
        </div>
        <div class='col-2 pt-3 '> 
            <input name="hot" type="radio" value="0"> Bình thường
            <input name="hot" type="radio" value="1" checked> Nổi bật
        </div>
        <div class="col-2 text-end pt-2 ">
            {{-- <label for="ton_kho">Số lượng tồn kho</label> --}}
            <input name="so_luong_con_lai" type="number" class="form-control shadow-none border-primary" min="0" placeholder="Số lượng tồn kho">
        </div>
    </div>
    <div class='mb-3 px-2'>
        <textarea name="mo_ta" rows="4" placeholder="Mô tả sản phẩm"
        class="form-control shadow-none border-primary"></textarea>
    </div>
    <div class='mb-3 px-2'> 
        <button type="submit" class="btn btn-dark py-2 px-5 border-0">Thêm sản phẩm mới</button>
    </div>
</form>
@endsection
