@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng  @endsection
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

<table class="table table-bordered m-auto" id="dsdonhang">
    {{-- <caption align="top" class="bg-warning fw-bolder">DANH SÁCH ĐƠN HÀNG</caption> --}}
    <h4 class="bg-gradient-dark text-white fw-bolder p-2">DANH SÁCH ĐƠN HÀNG CHO PHÉP TRẢ HÀNG</h4>
    {{-- <select id="trangthai" class="py-1 px-3 shadow-none" onchange="loctrangthai(this.value)">
        <option value="daxoa" {{$trangthai == "daxoa"? "selected":""}}>Đơn hàng đã xóa</option>
    </select>
    <script>
    function loctrangthai(tt){
        document.location=`/admin/donhang?trangthai=${tt}`;
    }
    </script> --}}
    @if($donhang->isEmpty())
        <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
            Chưa có đơn hàng nào.
        </div>
    @else
        <thead class="text-center">
            <tr>
                <th style="width: 80px">ID <br> đơn hàng</th>
                <th style="width: 100px">Họ và tên Email <br> Điện thoại Địa chỉ </th>
                <th style="width: 150px">Thời gian <br> Tổng số lượng <br>Tổng tiền</th>
                <th style="width: 130px">Trạng thái & Thanh toán</th>
                <th style="width: 100px">Loại<br>Thanh toán</th>
                <th style="width: 100px">Chi tiết</th>
                <th style="width: 50px">Xóa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donhang as $dh)
                <tr>
                    <td class="text-center">{{ $dh->id }}</td>
                    <td><span style="font-weight: bold">Tên:</span> {{ $dh->ten_nguoi_nhan }}<br><span style="font-weight: bold">Email:</span>  {{ $dh->email }} <br> <span style="font-weight: bold">SĐT:</span> {{ $dh->dien_thoai }}<br><span style="font-weight: bold">Address:</span>  {{ $dh->dia_chi_giao }}</td>
                    <td><span style="font-weight: bold">Thời gian: </span>{{date('d/m/Y',strtotime($dh->thoi_diem_mua_hang))}} <br><span style="font-weight: bold">SL:</span> {{ $dh->tong_so_luong }}<br><span style="font-weight: bold">Tiền:</span> {{ number_format( $dh->tong_tien , 0 , "," , ".") }} VNĐ</td>
                    <td>Đã cho phép (Trả hàng) &
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
                    
                    <td class="text-center">
                        <form action="{{ route('donhang.destroy', $dh->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type='submit' onclick="return confirm('Xác nhận xóa')" class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
    {{-- <tr> <td colspan="9"> {{$donhang->links() }} </td> </tr> --}}
<div class="p-2 d-flex justify-content-center">{{$donhang->links() }}</div>
@endif
@endsection
