@extends('admin/layoutadmin')
@section('title') Chinh sản phẩm  @endsection
@section('noidungchinh')
<form id="frm" method="post" action="{{route('sanpham.update', $sp->id )}}" class="m-auto w-10 border border-primary" > 
    @csrf @method('PUT')
    <h4 class="m-0 bg-gradient-dark text-white p-2 fs-5"> CHỈNH SẢN PHẨM</h4>
    <div class="mb-3 row px-2">
        <div class='col-6'> Tên sản phẩm 
            <input name="ten_sp" type="text" value="{{$sp->ten_sp}}" 
            class="form-control shadow-none border-primary">
        </div>
        <div class='col-6'> Ngày 
            <input name="ngay" type="date" value="{{$sp->ngay}}"
            class="form-control shadow-none border-primary" >
        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6'> Giá  
            <input name="gia" type="number" value="{{$sp->gia}}"
            class="form-control shadow-none border-primary" min="1">
        </div>
        <div class='col-6'> Giá km
          <input name="gia_km" type="number" value="{{$sp->gia_km}}"
          class="form-control shadow-none border-primary" min="1">
        </div>
    </div>
    <div class="mb-3 row px-2">    
        <div class='col-6'> 
            <select name="id_loai" class="form-control shadow-none border-primary">
                <option value="-1">Chọn loại</option>
                @foreach( $loai_arr as $loai)
                <option value="{{$loai->id}}" {{$loai->id==$sp->id_loai? "selected":""}} >
                    {{$loai->ten_loai}}
                </option>
                @endforeach
            </select>
        </div>   
        <div class='col-6'>
            <select name="tinh_chat" class="form-control shadow-none border-primary">
                <option value="0" {{$sp->tinh_chat==0? "selected":""}} >Tính chất</option>
                <option value="0" {{$sp->tinh_chat==0? "selected":""}} >Bình thường</option>
                <option value="1" {{$sp->tinh_chat==1? "selected":""}} >Giá rẻ</option>
                <option value="2" {{$sp->tinh_chat==2? "selected":""}} >Giảm sốc</option>
                <option value="3" {{$sp->tinh_chat==3? "selected":""}} >Cao cấp</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row px-2">
        <div class='col-6 p-2'> 
            <input name="hinh" type="text" value="{{$sp->hinh}}"
            placeholder="Hình sản phẩm"
            class="form-control shadow-none border-primary">
        </div>  
        <div class='col-2 pt-3'> 
            <input name="an_hien" type="radio" value="0" {{$sp->an_hien==0? "checked":""}} > Ẩn
            <input name="an_hien" type="radio" value="1" {{$sp->an_hien==1? "checked":""}} > Hiện
        </div>
        <div class='col-2 pt-3 pe-3'> 
            <input name="hot" type="radio" value="0" {{$sp->hot==0? "checked":""}} > Bình thường
            <input name="hot" type="radio" value="1" {{$sp->hot==1? "checked":""}} > Nổi bật
        </div>
        <div class='col-2 text-end pe-3'> 
            <label for="ton_kho">Số lượng tồn kho</label>
            <input type="number" class="form-control" id="ton_kho" name="ton_kho" value="{{ old('ton_kho', $sp->ton_kho) }}" required>
        </div>        
    </div>
    <div class='mb-3 px-2'>
        <textarea name="mo_ta" rows="4" placeholder="Mô tả sản phẩm"
        class="form-control shadow-none border-primary">{{$sp->mo_ta}}</textarea>
    </div>
    <div class='mb-3 px-2'> 
        <button type="submit" class="btn btn-dark py-2 px-5 border-0">Chỉnh sửa sản phẩm</button>
    </div>
</form>
@endsection
