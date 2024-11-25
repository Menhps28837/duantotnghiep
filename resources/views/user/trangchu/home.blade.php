@extends('layout')
@section('title') 
    Trang chủ  
@endsection

@section('noidungchinh')
    @include('user.trangchu.banner')
    @include('user.trangchu.spNoiBat')
    @include('user.trangchu.spLuotxemcao')
    @include('user.trangchu.tintuc')
@endsection


@push('css')  
    <style>
        
    </style>
@endpush

@push('javascript1')   

@endpush

@push('javascript2')  

@endpush
