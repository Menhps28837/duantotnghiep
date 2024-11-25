@extends('layout')
@section('title') 
    Thông báo 
@endsection
@section('noidungchinh')
    @if(session()->has('thongbao2'))
    <p>&nbsp; </p>
    <div class="alert alert-success p-5 col-8 h5 m-auto text-center shadow-lg">
       {!! session('thongbao2') !!}
    </div>
    <p>&nbsp;</p>
    @endif
@endsection
