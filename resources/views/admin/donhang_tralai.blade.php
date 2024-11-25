@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng  @endsection
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
@if($donhang->isEmpty())
    <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
        Chưa có đơn hàng nào.
    </div>
@else
<table class="table table-bordered m-auto" id="dsdonhang">
    {{-- <caption align="top" class="bg-warning fw-bolder">DANH SÁCH ĐƠN HÀNG</caption> --}}
    <h4 class="bg-gradient-dark text-white fw-bolder p-2">DANH SÁCH ĐƠN HÀNG YÊU CẦU TRẢ LẠI</h4>
    <thead class="text-center">
        <tr>
            <th style="width: 80px">ID <br> đơn hàng</th>
            <th style="width: 100px">Họ và tên Email <br> Điện thoại Địa chỉ </th>
            <th style="width: 150px">Thời gian <br> Tổng số lượng <br>Tổng tiền</th>
            <th style="width: 130px">Trạng thái & Thanh toán</th>
            <th style="width: 100px">Loại<br>Thanh toán</th>
            <th style="width: 50px">Chi tiết</th>
            <th style="width: 80px">Cho phép <br> Từ chối</th>
            <th style="width: 50px">Gửi email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donhang as $dh)
            <tr>
                <td class="text-center">{{ $dh->id }}</td>
                    <td><span style="font-weight: bold">Tên:</span> {{ $dh->ten_nguoi_nhan }}<br><span style="font-weight: bold">Email:</span>  {{ $dh->email }} <br> <span style="font-weight: bold">SĐT:</span> {{ $dh->dien_thoai }}<br><span style="font-weight: bold">Address:</span>  {{ $dh->dia_chi_giao }}</td>
                    <td><span style="font-weight: bold">Thời gian: </span>{{date('d/m/Y',strtotime($dh->thoi_diem_mua_hang))}} <br><span style="font-weight: bold">SL:</span> {{ $dh->tong_so_luong }}<br><span style="font-weight: bold">Tiền:</span> {{ number_format( $dh->tong_tien , 0 , "," , ".") }} VNĐ</td>
                <td>Đang chờ xử lý
                    @if ($dh->yeu_cau_tra_hang && $dh->yeu_cau_tra_hang->created_at >= $thoiGianMoi)
                        <span style="font-size: 12px" class="badge bg-info">Mới</span> 
                    @endif
                    &<br>
                    @if ($dh->trang_thai_thanh_toan == 0)
                        Chưa thanh toán
                    @elseif ($dh->trang_thai_thanh_toan == 2)
                        Đã thanh toán
                    @else
                        Không xác định
                    @endif
                </td>
               
                <td>{{ $dh->loai_thanh_toan == 0 ? "Thanh toán khi nhận hàng" : "Chuyển khoản" }}</td>
                <td class="text-center"><a class="btn btn-primary btn-sm" href="{{ route('donhang.chitietxacnhan', $dh->id) }}">Chi tiết sản phẩm</a></td>
                
                <td class="text-center">
                    <form action="{{ route('donhang.chophep', $dh->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" onclick="return confirm('Xác nhận cho phép trả hàng')" class="btn btn-primary btn-sm mb-1">Cho phép</button>
                    </form>
                    
                    <form action="{{ route('donhang.tuchoi', $dh->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button style="width: 80px;" type='submit' onclick="return confirm('Xác nhận từ chối trả hàng')" class="btn btn-danger btn-sm">
                            Từ chối
                        </button>
                    </form>
                    
                </td>
                <td>
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#returnModal{{ $dh->id }}">
                        Hỏi thêm lý do
                    </button>
                    
                    <!-- Modal hỏi thêm lý do -->
                    <div class="modal fade" id="returnModal{{ $dh->id }}" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('donhang.traloitrahang', ['id' => $dh->id]) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="returnModalLabel">Hỏi thêm lý do</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="mb-2" for="cauHoi">Vui lòng nhập câu hỏi:</label>
                                            <textarea name="cauHoi" id="cauHoi" class="form-control" placeholder="Nhập câu hỏi của bạn tại đây..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-warning">Gửi câu hỏi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @if ($dh->yeu_cau_tra_hang)
                {{-- @foreach ($dh->yeu_cau_tra_hang as $request) --}}
                    <tr>
                        <td colspan="10">
                            <strong>Lý do trả hàng:</strong>
                            @if ($dh->yeu_cau_tra_hang->reasons)
                                @php
                                    $reasons = json_decode($dh->yeu_cau_tra_hang->reasons, true); // Giải mã JSON
                                @endphp
                                <ul>
                                    @foreach ($reasons as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Không có lý do cụ thể
                            @endif
                            <strong>Chi tiết lý do:</strong> {{ $dh->yeu_cau_tra_hang->lydo }}
                        </td>
                    </tr>
                {{-- @endforeach --}}
            @endif
        @endforeach
    </tbody>
</table>
<div class="p-2 d-flex justify-content-center">{{ $donhang->links() }}</div>
@endif
@endsection
