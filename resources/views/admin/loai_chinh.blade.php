@extends('admin/layoutadmin')
@section('title') Chỉnh loại sản phẩm  @endsection
@section('noidungchinh')
<form  action="{{route('loai.update', $loaisp->id )}}" method="post"
class="m-auto col-10 border border-primary p-3 mt-3 shadow-lg fs-5">
    @csrf @method('PUT')
    <h4 class="m-0 bg-gradient-dark text-white p-2 fs-5"> CHỈNH SỬA LOẠI</h4>
    <div class='mb-3'> 
        <label> Tên loại</label> 
        <input name="ten_loai" value="{{$loaisp->ten_loai}}" type="text" 
        class="form-control border-primary shadow-none">
    </div>
    <div class='mb-3'> 
        <label> Thứ tự</label> 
        <input name="thu_tu" value="{{$loaisp->thu_tu}}" type="number" 
        class="form-control border-primary shadow-none" min="1">
    </div>
    <div class='mb-3'> 
        <label> Ẩn hiện</label> 
        <input name="an_hien" {{$loaisp->an_hien==0?"checked":""}} type="radio" value="0"> Ẩn
        <input name="an_hien" type="radio" value="1" {{$loaisp->an_hien==1?"checked":""}} > Hiện
    </div>
    <div class='mb-3'> 
        <button type="submit" class="btn btn-dark py-2 px-5 border-0">Chỉnh sửa loại</button>
    </div>
</form>

@endsection
