@extends('admin/layoutadmin')
@section('title') Danh sách sản phẩm  @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
<table class="table table-bordered m-auto" id="dssanpham">
    {{-- <caption align="top" class="bg-warning fw-bolder">DANH SÁCH SẢN PHẨM</caption> --}}
    <h4 class="bg-gradient-dark text-white p-2">DANH SÁCH SẢN PHẨM</h4>
    @if($sanpham_arr->isEmpty())
        <div class="alert alert-warning">Không tìm thấy tên sản phẩm này.</div>
    @endif
    <tr><td colspan="4">
        <select id="selLoai" class="py-1 px-3 shadow-none" onchange="locsp(this.value)" >
            <option value="-1">Lọc theo NSX</option>
            @foreach ($loai_arr as $loai)
            <option value="{{$loai->id}}" {{$loai->id == $id_loai? "selected":""}} >
                {{$loai->ten_loai}}
            </option>
            @endforeach
        </select>
        <script>
        function locsp(id_loai) {
            document.location=`/admin/sanpham?id_loai=${id_loai}`;
        }
        </script>
        
        <select id="trangthai" class="py-1 px-3 shadow-none" onchange="loctrangthai(this.value)">
            <option value="chuaxoa" {{$trangthai == "chuaxoa"? "selected":""}}>Sản phẩm hiện hành</option>
            <option value="daxoa" {{$trangthai == "daxoa"? "selected":""}}>Sản phẩm đã xóa</option>
        </select>
        <script>
        function loctrangthai(tt){
            document.location=`/admin/sanpham?trangthai=${tt}`;
        }
        </script>
        <td colspan="3">

            <form method="GET" action="{{ route('sanpham.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="clearSearch()">x</button>
                        <button class="bg-gradient-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </form>
            <script>
                function clearSearch() {
                    document.querySelector('input[name="search"]').value = ''; // Xóa nội dung ô tìm kiếm
                    document.querySelector('form').submit(); // Gửi form để cập nhật danh sách
                }
            </script>
        </td>
    
        </td>

    </tr>

    <tr class="text-center">
        <th>Hình</th> 
        <th style="width: 280px">Tên sản phẩm</th> 
        <th>Giá</th>
        <th>Ngày</th> 
        <th>Trạng thái</th> 
        <th >SL tồn kho</th>
        <th style="width: 120px">Sửa Xóa</th>
    </tr>
    @foreach($sanpham_arr as $sp)
    <tr>
    {{-- <tr> --}}
        <td><img src="{{$sp->hinh}}" width="120" height="80"></td>   
        <td><b>{{$sp->ten_sp}}</b> <br> Lượt xem: {{$sp->luot_xem}}
        </td>
        <td class="spgia">Giá : <br> {{ number_format($sp->gia,0,',', '.') }} VNĐ <br>
            Giá KM : <br> {{ number_format($sp->gia_km,0,',', '.') }} VNĐ
        </td>
        <td> {{date('d/m/Y',strtotime($sp->ngay))}}</td>
        <td class="trangthai"> Ẩn hiện: {{($sp->an_hien==0)? "Đang ẩn":"Đang hiện"}} <br>
             Nổi bật: {{($sp->hot==0)? "Bình thường":"Nổi bật"}} 
        </td>
        <td class="text-center sltonkho">{{ $sp->ton_kho }}</td>
        <td class="text-center"> 
        <a class="btn btn-dark btn-sm" href="{{route('sanpham.edit', $sp->id)}}">Sửa</a>       
        <form class="d-inline" action="{{ route('sanpham.destroy', $sp->id) }}" method="POST">
            @csrf @method('DELETE')
            <button type='submit' onclick="return confirm('Xác nhận xóa')" class="btn btn-danger btn-sm">
            Xóa
            </button>
        </form>
     
       </td>
    </tr>
    @endforeach
</table>
<div class="mt-3 mb-5"> {{ $sanpham_arr->links() }} </div> 
@endsection
