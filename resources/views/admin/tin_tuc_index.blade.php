@extends('admin/layoutadmin')
@section('title') Danh sách tin tức  @endsection
@section('noidungchinh')
    <div class="container">
        <h2 class="my-4">Danh Sách Tin Tức</h2>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('thongbao2'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao2') !!}
    </div>
@endif

        <a href="{{ route('admin.tin_tuc.create') }}" class="btn btn-primary mb-3">Thêm Tin Tức</a>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 400px">Tiêu Đề</th>
                    <th style="width: 400px">Nội dung</th>
                    <th style="width: 300px">Hình ảnh</th>
                    <th>Ngày Đăng</th>
                    <th style="width: 170px">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tinTucs as $tinTuc)
                    <tr>
                        <td>{{ Str::limit($tinTuc->tieu_de, 20) }}</td>
                        <td>{{ Str::limit($tinTuc->noi_dung, 20) }}</td>
                        <td><img src="{{ asset('storage/tin_tuc/' . $tinTuc->anh) }}" class="card-img-top" alt="{{ $tinTuc->tieu_de }}"></td>
                        <td>{{date('d/m/Y',strtotime($tinTuc->ngay_dang))}}</td>
                        <td>
                            <a href="{{ route('admin.tin_tuc.edit', $tinTuc->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('admin.tin_tuc.destroy', $tinTuc->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Xác nhận xóa')" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
<div class="p-2 d-flex justify-content-center">{{$tinTucs->links() }}</div>

    </div>
@endsection
