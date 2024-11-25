@extends('admin/layoutadmin')
@section('title') Danh sách user  @endsection
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
    <table class="table table-bordered m-auto" id="dsdonhang">
        <h4 class="bg-gradient-dark text-white fw-bolder p-2">DANH SÁCH USER</h4>
        <form method="GET" action="{{ route('user.index') }}">
            <div class="input-group mb-2">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên hoặc email" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">x</button>
                <button class="bg-gradient-dark btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
        
        <script>
            function clearSearch() {
                document.querySelector('input[name="search"]').value = ''; 
                document.querySelector('form').submit(); 
            }
        </script>

        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th style="width: 230px">Tên</th>
                <th style="width: 230px">Email</th>
                <th>Địa chỉ</th>
                <th>Điện thoại</th>
                <th>Role</th>
                <th style="width: 150px">Sửa Xóa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $ur)
                <tr>
                    <td>{{ $ur->id }}</td>
                    <td>{{ $ur->name }}
                        @if ($ur->created_at >= $thoiGianMoi)
                            <span class="badge bg-info">Mới</span>
                        @endif
                    </td>
                    <td>{{ $ur->email }}</td>
                    <td>{{ $ur->dia_chi }}</td>
                    <td class="text-center">{{ $ur->dien_thoai }}</td>
                    <td class="text-center">{{ $ur->role==1? "Admin":"User" }}</td>
                    <td class="text-center">
                        <a class="btn btn-dark btn-sm" href="{{ route('user.edit', $ur->id) }}">Sửa</a> 
                        <form action="{{ route('user.destroy', $ur->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type='submit' onclick="return confirm('Xác nhận xóa')" class="btn btn-danger btn-sm">
                                Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
<div class="p-2 d-flex justify-content-center">{{$user->links() }}</div>
@endsection
