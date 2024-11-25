@extends('layout')
@section('title') Cảm ơn {{ $order->ten_nguoi_nhan }} @endsection
@section('noidungchinh')

    <h1>Cảm ơn {{ $order->ten_nguoi_nhan }}!</h1>
    <p>Đơn hàng của bạn đã được xác nhận thành công.</p>
    <p>ID Đơn Hàng: {{ $order->id }}</p>
    <p>Chúng tôi rất cảm ơn bạn đã mua hàng từ chúng tôi. Hẹn gặp lại bạn lần sau!</p>

@endsection
