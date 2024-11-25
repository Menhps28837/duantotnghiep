@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng đã giao  @endsection
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
@if(session()->has('info'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('info') !!}
    </div>
@endif
@if($donhang->isEmpty())
    <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
        Chưa có đơn hàng nào.
    </div>
@else
<table class="table table-bordered m-auto" id="dsdonhang">
    <div style="margin-left: 0px; margin-right: 0px" class="row bg-warning fw-bolder">
        <div class="col-6">
            <label class="mt-2 mb-2">DANH SÁCH ĐƠN HÀNG ĐÃ GIAO</label>
        </div>
        <div class="col-6 text-end">
            <label class="mt-2 mb-2"><a style="text-decoration: none; color: black" href="{{url('/admin/donhang')}}">Về danh sách đơn hàng</a></label>
        </div>
    </div>
    {{-- <select id="trangthai" class="py-1 px-3 shadow-none" onchange="loctrangthai(this.value)">
        <option value="daxoa" {{$trangthai == "daxoa"? "selected":""}}>Đơn hàng đã xóa</option>
    </select>
    <script>
    function loctrangthai(tt){
        document.location=`/admin/donhang?trangthai=${tt}`;
    }
    </script> --}}
        <thead class="text-center">
            <tr>
                <th style="width: 100px">ID <br> đơn hàng</th>
                <th style="width: 230px">Họ và tên <br>Email</th>
                <th style="width: 250px">Điện thoại <br>Địa chỉ</th>
                <th style="width: 120px">Thời gian</th>
                <th>Tổng số lượng <br>Tổng tiền</th>
                <th>Trạng thái</th>
                <th style="width: 150px">Thanh toán</th>
                <th style="width: 150px">Loại<br>Thanh toán</th>
                <th style="width: 100px">Chi tiết</th>
                {{-- <th>Sửa Xóa</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($donhang as $dh)
                <tr>
                    <td class="text-center">{{ $dh->id }}</td>
                    <td><span style="font-weight: bold">Tên:</span> {{ $dh->ten_nguoi_nhan }}<br><span style="font-weight: bold">Email:</span>  {{ $dh->email }}</td>
                    <td><span style="font-weight: bold">SĐT:</span> {{ $dh->dien_thoai }}<br><span style="font-weight: bold">Address:</span>  {{ $dh->dia_chi_giao }}</td>
                    <td> {{date('d / m / Y',strtotime($dh->thoi_diem_mua_hang))}}</td>
                    <td><span style="font-weight: bold">SL:</span> {{ $dh->tong_so_luong }}<br><span style="font-weight: bold">Tiền:</span> {{ number_format( $dh->tong_tien , 0 , "," , ".") }} VNĐ</td>


                    <td>Đã giao thành công</td>
                    <td>
                        @if ($dh->trang_thai_thanh_toan == 0)
                            Chưa thanh toán
                        @elseif ($dh->trang_thai_thanh_toan == 2)
                            Đã thanh toán
                        @else
                            Không xác định
                        @endif
                    </td>
                    <td>{{ $dh->loai_thanh_toan==0? "Thanh toán khi nhận hàng":"Chuyển khoản" }}</td>
                    <td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('donhang.chitietxacnhan', $dh->id) }}">Chi tiết sản phẩm</a></td>
                  
                </tr>
            @endforeach
        </tbody>
</table>

<div class="p-2 d-flex justify-content-center">{{$donhang->links() }}</div>
@endif
@endsection
