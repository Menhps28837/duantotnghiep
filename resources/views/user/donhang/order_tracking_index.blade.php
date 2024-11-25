@extends('layout')
@section('title') Theo dõi đơn hàng @endsection
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

{{-- @if(session()->has('returnRequest'))
    <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
        Yêu cầu trả hàng của bạn đã được ghi nhận. <br>
        <strong>Lý do:</strong> {{ session('returnRequest')->lydo }} <br>
        <strong>Trạng thái:</strong> 
        @if(session('returnRequest')->status == 0)
            Chờ phê duyệt
        @elseif(session('returnRequest')->status == 1)
            Đã phê duyệt
        @elseif(session('returnRequest')->status == 2)
            Đã từ chối
        @else
            Không xác định
        @endif
    </div>
@endif --}}

    <div class="container mt-5">
        <h1>Danh Sách Đơn Hàng Của Bạn</h1>
        @if($orders->isEmpty())
            <p>Bạn chưa có đơn hàng nào.</p>
        @else
            <table class="table table-theodoidonhang">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tổng số lượng</th>
                        <th style="width: 180px">Tổng tiền</th>
                        <th>Trạng Thái</th>
                        <th>Thanh toán</th>
                        <th>Loại thanh toán</th>
                        <th>Ngày đặt hàng</th>
                        <th>Chi Tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->tong_so_luong }}</td>
                            <td>{{ number_format( $order->tong_tien , 0 , "," , ".") }} VNĐ</td>
                            <td>
                                @if ($order->trang_thai == 0)
                                    Đang chờ xác minh
                                @elseif ($order->trang_thai == 1)
                                    Đã xác nhận
                                @elseif ($order->trang_thai == 2)
                                    Đã hủy
                                @elseif ($order->trang_thai == 3)
                                    Đã giao cho shipper
                                @elseif ($order->trang_thai == 4)
                                    Đã giao thành công
                                @elseif ($order->trang_thai == 5)
                                    Đơn hàng đã hoàn thành  
                                @elseif ($order->trang_thai == 6)
                                    Đang chờ xử lý (Trả hàng)
                                @elseif ($order->trang_thai == 7)
                                    Cho phép (Trả hàng)
                                @elseif ($order->trang_thai == 8)
                                    Từ chối (Trả hàng)
                                @else
                                    Không xác định
                                @endif
                            </td>                            
                            
                            <td>
                                @if ($order->trang_thai_thanh_toan == 0)
                                    Chưa thanh toán
                                @elseif ($order->trang_thai_thanh_toan == 1)
                                    Đã thanh toán (chờ xác minh)
                                @elseif ($order->trang_thai_thanh_toan == 2)
                                    Đã thanh toán 
                                @else
                                    Không xác định
                                @endif

                            </td>
                            {{-- <td>{{ $order->trang_thai==1? "Đã xác nhận":"Chưa xác nhận" }}</td> --}}
                            <td>{{ $order->loai_thanh_toan==0? "Thanh toán khi nhận hàng":"Chuyển khoản" }}</td>
                            <td>{{date('d/m/Y',strtotime($order->thoi_diem_mua_hang))}}</td>
                            <td>
                                <a class="btn btn-dark btn-sm xemchitiet" href="{{ route('user.donhang.order.tracking', ['id' => $order->id]) }}">Xem Chi Tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
