@extends('admin/layoutadmin')
@section('title') Hóa Đơn @endsection
@section('noidungchinh')
<div class="container">
    <div style="margin-left: 0px; margin-right: 0px" class="row bg-warning fw-bolder">
        <div class="col-6">
            <label class="mt-2 mb-2 fs-5">HÓA ĐƠN</label>
        </div>
        <div class="col-6 text-end">
            <label class="mt-2 mb-2">
                <a href="javascript:void(0);" onclick="history.back();" style="text-decoration: none; color: black">QUAY LẠI</a>
            </label>
        </div>
    </div>

    <div class="printable">
        <h1 class="text-center">Hóa Đơn Mã {{$donhang->id}}</h1>
        <p><strong>Tên khách hàng:</strong> {{ $donhang->ten_nguoi_nhan }}</p>
        <p><strong>Email:</strong> {{ $donhang->email }}</p>
        <p><strong>Điện thoại:</strong> {{ $donhang->dien_thoai }}</p>
        <p><strong>Địa chỉ:</strong> {{ $donhang->dia_chi_giao }}</p>
        <h3>Chi tiết đơn hàng</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th> Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ctdh as $ct)
                <tr>
                    <td>{{ $ct->ten_sp }}</td>
                    <td><img src="{{ $ct->hinh }}" alt="" style="width: 200px"></td>
                    <td>{{ $ct->so_luong }}</td>
                    <td>{{ number_format($ct->gia_km, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($ct->gia_km * $ct->so_luong, 0, ',', '.') }} VNĐ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <h4>Tổng tiền: {{ number_format($tongTien, 0, ',', '.') }} VNĐ</h4>
        <button onclick="window.print()" class="btn btn-primary no-print">In hóa đơn</button>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden; 
        }
        .printable, .printable * {
            visibility: visible; 
        }
        .printable {
            position: absolute; 
            left: 0;
            top: 0;
        }
        button {
            display: none; 
        }
        .no-print {
            display: none;
        }
    }
</style>
@endsection
