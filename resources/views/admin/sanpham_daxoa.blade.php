@extends('admin/layoutadmin')
@section('title') Danh sách sản phẩm  @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
<table class="table table-bordered m-auto" id="dssanpham">
    {{-- <caption align="top" class="bg-warning fw-bolder">DANH SÁCH SẢN PHẨM</caption> --}}
    <h4 class="bg-gradient-dark text-white fw-bolder p-2">DANH SÁCH SẢN PHẨM XÓA MỀM</h4>
    <tr><td colspan="6">
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
    </td>
    </tr>

    <tr><th>Hình</th> 
        <th>Tên sản phẩm</th> 
        <th>Giá</th>
        <th>Ngày</th> 
        <th>Trạng thái</th> 
        <th>Số lượng tồn kho</th>
        <th>Sửa Xóa</th>
    </tr>
    @foreach($sanpham_arr as $sp)
    <tr><td><img src="{{$sp->hinh}}" width="120" height="80"></td>   
        <td><b>{{$sp->ten_sp}}</b> <br> Lượt xem: {{$sp->luot_xem}}
        </td>
        <td>Giá: {{ number_format($sp->gia,0,',', '.') }} VNĐ<br>
            KM : {{ number_format($sp->gia_km,0,',', '.') }} VNĐ
        </td>
        <td> {{date('d/m/Y',strtotime($sp->ngay))}}</td>
        <td> Ẩn hiện: {{($sp->an_hien==0)? "Đang ẩn":"Đang hiện"}} <br>
             Nổi bật: {{($sp->hot==0)? "Bình thường":"Nổi bật"}} 
        </td>
        <td>{{ $sp->ton_kho }}</td>
        <td> 
            <a href="sanpham/khoi-phuc/{{ $sp->id }}" class="btn btn-dark btn-sm">Khôi phục</a>
            <a href="sanpham/xoa-vinh-vien/{{$sp->id}}" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận Xóa vĩnh viễn?')">Xóa vĩnh viễn</a>
     
       </td>
    </tr>
    @endforeach
    <tr> <td colspan="6"> {{ $sanpham_arr->links() }} </div> </td> </tr>
</table>
@endsection
