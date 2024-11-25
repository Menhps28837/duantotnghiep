@extends('layout')
@section('title')
    {{ $ten_loai }}       
@endsection

@section('noidungchinh')
    @include('user.sanpham.sptrongloai_a')
@endsection

@push('css')  @endpush
@push('javascript1')   @endpush
@push('javascript2')   @endpush
