@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng chi tiết @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
<table class="table table-bordered m-auto" id="dsctdonhang">
    <div style="margin-left: 0px; margin-right: 0px" class="row bg-gradient-dark fw-bolder">
        <div class="col-6">
            <label class=" text-white mt-2 mb-2 mr-3">CHI TIẾT ĐƠN HÀNG </label>
            {{-- <button onclick="printInvoice()" class="btn btn-primary no-print">In hóa đơn</button> --}}
            <a href="{{ route('donhang.invoice', $ctdh[0]->id_dh) }}" class="btn btn-primary">In hóa đơn</a>
        </div>
        <div class="col-6 text-end">
            <label class="mt-2 mb-2">
                <a href="javascript:void(0);" onclick="history.back();" style="text-decoration: none; color: white">QUAY LẠI</a>
            </label>
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
        <thead>
            <tr class="text-center">
                <th>ID CT <br> đơn hàng</th>
                {{-- <th>ID_dh</th> --}}
                {{-- <th>ID_sp</th> --}}
                <th>Tên sản phẩm</th>
                <th>Hình</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
                
            </tr>
        </thead>
        <tbody class="text-center">
            @php
                // $thanh_tien = 0;
                $tongSoLuong = 0;
                $TongTien = 0;
            @endphp
            @foreach ($ctdh as $ct)
            @php
                $ct->thanh_tien += $ct->gia_km * $ct->so_luong;
            @endphp
                <tr>
                    <td>{{ $ct->id }}</td>
                    {{-- <td>{{ $ct->id_dh }}</td> --}}
                    {{-- <td>{{ $ct->id_sp }}</td> --}}
                    <td>{{ $ct->ten_sp }}</td>
                    <td><img style="height:100px; width: 80%" src="{{ $ct->hinh }}" alt=""></td>
                    <td>{{ $ct->so_luong }}</td>
                    <td>{{ number_format( $ct->gia_km , 0 , "," , ".") }} VNĐ</td>
                    <td>{{ number_format( $ct->thanh_tien , 0 , "," , ".") }} VNĐ</td>
                </tr>
                @php
                    $tongSoLuong += $ct->so_luong;
                    $TongTien += $ct->thanh_tien;
                @endphp
            @endforeach
            <th colspan="8" class='text-center'>
                Số sản phẩm : {{$tongSoLuong}} 
                <p>Tổng tiền : {{number_format($TongTien, 0,',','.')}} VNĐ</p>
            </th>
            {{-- <form action="{{route('donhang.xacnhan', $ct->id_dh)}}" method="POST"> @csrf  @method('PATCH')
                <th colspan="1" class='text-center'>
                    <button type="submit" class="btn btn-success mt-2">Xác Nhận Đơn Hàng</button>
                </th>
            </form> --}}
        </tbody>
</table>
<script>
    function printInvoice() {
        window.print(); // In ra toàn bộ nội dung trong trang hiện tại
    }
    </script>
@endsection
