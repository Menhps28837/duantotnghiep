@extends('admin/layoutadmin')
@section('title') Danh sách doanh thu tháng {{ $thang }}  @endsection
@section('noidungchinh')
<div class="container">
    <div class="row">
        <div class="col-10">
            <h1>Chi Tiết Doanh Thu - Tháng {{ $thang }} / Năm {{ $nam }}</h1>
        </div>
        <div class="col-2 fs-4 mt-2 text-end">
            <span><a style="text-decoration: none; color: rgb(115, 114, 114)" href="{{ route('admin.doanhthu') }}">Quay lại</a></span>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Mã Đơn Hàng</th>
                <th></th>
                <th>Ngày Mua Hàng</th>
                <th></th>
                <th>Tổng Tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chiTiet as $item)
            <tr>
                <td><a style="text-decoration: none" href="{{ route('donhang.chitietxacnhan', $item->id) }}">{{ $item->id }}</a></td>
                <td></td>
                <td>{{ date('d / m / Y',strtotime($item->thoi_diem_mua_hang)) }}</td>
                <td></td>
                <td>{{ number_format($item->tong_tien) }} VNĐ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Tổng Số Đơn Hàng: {{ $tongSoLuong }}</h4>
    <h4>Tổng Doanh Thu: {{ number_format($tongDoanhThu) }} VNĐ</h4>
</div>
@endsection
