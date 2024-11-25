@extends('layout')
@section('title') Cảm ơn  @endsection
@section('noidungchinh')
    <div class="alert alert-info text-center">
    @if(Session::exists('thongbao'))
        <h4>{{ Session::get('thongbao') }}</h4> <hr>
        @endif
        <p>Cảm ơn quý khách đã đặt hàng</p>
    <a href="/">Trở về</a>
    </div>
@endsection 