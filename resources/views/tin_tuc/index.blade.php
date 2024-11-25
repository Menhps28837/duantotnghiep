@extends('layout')
@section('title') Tin tức @endsection
@section('noidungchinh')
<div class="container">
    <h2 class="my-4">Tin Tức Mới Nhất</h2>
    <div class="row d-flex">
        @foreach($tinTucs as $tinTuc)
            <div class="col-md-4 mb-4">
                <div class="card h-100 d-flex flex-column"> 
                    <img style="height: 150px" src="{{ asset('storage/tin_tuc/' . $tinTuc->anh) }}" class="card-img-top" alt="{{ $tinTuc->tieu_de }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($tinTuc->tieu_de, 50) }}</h5>
                        <p class="card-text">{{ Str::limit($tinTuc->noi_dung, 200) }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">Ngày đăng: {{date('d/m/Y',strtotime($tinTuc->ngay_dang))}}</p>
                        <a href="{{ route('tin_tucs.show', $tinTuc->id) }}" class="btn btn-primary">Xem Chi Tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
