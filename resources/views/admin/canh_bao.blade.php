@extends('admin.layoutadmin')
@section('title', 'Sản phẩm cảnh báo')
@section('noidungchinh')
<h4 class="bg-gradient-dark text-white fw-bolder p-2">Sản phẩm có số lượng cảnh báo</h4>
{{-- <h1 class="text-center">Sản phẩm có số lượng cảnh báo</h1> --}}

@if (count($canh_bao) > 0)
    <table class="table table-bordered mt-4">
        <thead>
            <tr class="text-center">
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá / Giá khuyến mãi</th>
                <th>Ngày</th>
                {{-- <th>Tính chất</th> --}}
                <th>Ẩn/Hiện / Tính chất</th>
                <th>Số lượng còn lại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($canh_bao as $sp)
                <tr>
                    {{-- <td><a href="{{ $sp['edit_link'] }}">{{ $sp['ten_sp'] }}</a></td> --}}
                    <td><a style="text-decoration: none; color: black" href="">{{ $sp['ten_sp'] }}</a></td>
                    <td><a href=""><img src="{{ $sp['hinh'] }}" alt="" width="120" height="80"></a></td>
                    <td>Giá: {{ number_format($sp['gia'], 0, ',', '.') }} VNĐ <br>Giá KM: {{ number_format($sp['gia_km'], 0, ',', '.') }} VNĐ</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($sp['ngay'])->format('d/m/Y') }}</td>
                    {{-- <td>{{ $sp['tinh_chat'] }}</td> --}}
                    <td> Ẩn hiện: {{ $sp['an_hien'] == 0 ? "Đang ẩn" : "Đang hiện" }} <br>
                        Nổi bật: {{ $sp['hot'] == 0 ? "Bình thường" : "Nổi bật" }} 
                   </td>
                    <td class="text-center">{{ $sp['so_luong_con_lai'] }}</td>
                    <td class="text-center">
                        <a href="{{ $sp['edit_link'] }}" class="btn btn-dark">Chỉnh sửa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">Không có sản phẩm nào cần cảnh báo.</div>
@endif
@endsection
