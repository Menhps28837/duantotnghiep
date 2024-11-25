@extends('admin/layoutadmin')
@section('title') Danh sách doanh thu  @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5 text-center">
        {!! session('thongbao') !!}
    </div>
@endif
@if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5 text-center">
        {!! session('thongbao2') !!}
    </div>
@endif
@if(session()->has('info'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5 text-center">
        {!! session('info') !!}
    </div>
@endif

<div class="container">
    <h1>Tổng Doanh Thu</h1>
    
    @foreach($doanhThu->groupBy('nam') as $nam => $thangData)
        <div class="year-section">
            <h3 class="bg-primary text-white p-2">Năm {{ $nam }}</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th>Năm</th>
                        <th>Tổng Đơn Hàng</th>
                        <th>Tổng Doanh Thu</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $tongSoLuongNam = 0;
                        $tongDoanhThuNam = 0;
                    @endphp
                    @foreach($thangData as $item)
                        @php
                            $tongSoLuongNam += $item->so_luong_don_hang;
                            $tongDoanhThuNam += $item->tong_doanh_thu;
                        @endphp
                        <tr>
                            <td><a href="{{ route('admin.doanhthudetail', ['thang' => $item->thang, 'nam' => $item->nam]) }}">{{ $item->thang }}</a></td>
                            <td>{{ $item->nam }}</td>
                            <td>{{ $item->so_luong_don_hang }}</td>
                            <td>{{ number_format($item->tong_doanh_thu) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary">
                <h4>Tổng Số Đơn Hàng Trong Năm {{ $nam }}: {{ $tongSoLuongNam }}</h4>
                <h4>Tổng Doanh Thu Trong Năm {{ $nam }}: {{ number_format($tongDoanhThuNam) }} VNĐ</h4>
            </div>
        </div>
    @endforeach

</div>
@endsection
