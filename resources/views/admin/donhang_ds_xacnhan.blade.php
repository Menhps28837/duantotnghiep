@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng đã xác nhận @endsection
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
    <div style="margin-left: 0px; margin-right: 0px" class="row bg-gradient-dark text-white fw-bolder">
        <div class="col-6">
            <label class="mt-2 mb-2">DANH SÁCH ĐƠN HÀNG ĐÃ XÁC NHẬN</label>
        </div>
        <div class="col-6 text-end">
            <label class="mt-2 mb-2"><a style="text-decoration: none; color: white" href="{{url('/admin/donhang')}}">Về danh sách đơn hàng</a></label>
        </div>
    </div>
    @if($donhang->isEmpty())
            <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
                Hiện tại chưa có đơn hàng nào khác.
            </div>
        @else
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
                <th style="width: 80px">ID <br> đơn hàng</th>
                <th style="width: 100px">Họ và tên Email <br> Điện thoại Địa chỉ </th>
                <th style="width: 150px">Thời gian <br> Tổng số lượng <br>Tổng tiền</th>
                <th style="width: 130px">Trạng thái & Thanh toán</th>
                <th style="width: 100px">Loại<br>Thanh toán</th>
                <th style="width: 50px">Chi tiết</th>
                <th style="width: 50px">Giao shipper</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donhang as $dh)
                <tr>
                    <td class="text-center">{{ $dh->id }}</td>
                    <td><span style="font-weight: bold">Tên:</span> {{ $dh->ten_nguoi_nhan }}<br><span style="font-weight: bold">Email:</span>  {{ $dh->email }} <br> <span style="font-weight: bold">SĐT:</span> {{ $dh->dien_thoai }}<br><span style="font-weight: bold">Address:</span>  {{ $dh->dia_chi_giao }}</td>
                    <td><span style="font-weight: bold">Thời gian: </span>{{date('d/m/Y',strtotime($dh->thoi_diem_mua_hang))}} <br><span style="font-weight: bold">SL:</span> {{ $dh->tong_so_luong }}<br><span style="font-weight: bold">Tiền:</span> {{ number_format( $dh->tong_tien , 0 , "," , ".") }} VNĐ</td>

                    <td>Đã xác minh <br>
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
                        {{-- <a class="btn btn-primary btn-sm" href="{{ route('donhang.edit', $dh->id) }}">Sửa</a>  --}}
                        <form action="{{ route('donhang.giaohang', $dh->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            {{-- @method('DELETE') --}}
                            <button type='submit' onclick="return confirm('Xác nhận giao cho shipper')" class="btn btn-danger btn-sm">
                                Chuyển qua shipper
                            </button>
                        </form>
                        {{-- <form action="{{route('donhang.xacnhan', $ct->id_dh)}}" method="POST"> @csrf  @method('PATCH')
                            <th colspan="1" class='text-center'>
                                <button type="submit" class="btn btn-success mt-2">Xác Nhận Đơn Hàng</button>
                            </th>
                        </form> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
</table>
<div class="p-2 d-flex justify-content-center">{{$donhang->links() }}</div>
@endif
@endsection
