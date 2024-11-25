@extends('admin/layoutadmin')
@section('title') Danh sách đơn hàng đã xác nhận @endsection
@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbao') !!}
    </div>
@endif
@if ($khuyenmai_arr->isEmpty())
    <div class="alert alert-info">Không có liên hệ nào.</div>
@else
    <h1 class="mt-4  text-center">Quản lý sản phẩm khuyến mãi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá khuyến mãi</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($khuyenmai_arr as $khuyenmai)
                <tr>
                    <td>{{ $khuyenmai->ten_sp }}</td>
                    <td>{{ number_format($khuyenmai->gia_km, 0, ',', '.') }} VNĐ</td>
                    <td>{{ date('d/m/Y', strtotime($khuyenmai->ngay_bat_dau)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($khuyenmai->ngay_ket_thuc)) }}</td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $khuyenmai->id }}">Cập nhật</button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $khuyenmai->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $khuyenmai->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.khuyenmai.update') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $khuyenmai->id }}">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $khuyenmai->id }}">Cập nhật khuyến mãi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="gia_km" class="form-label">Giá khuyến mãi</label>
                                                <input type="number" class="form-control" name="gia_km" value="{{ $khuyenmai->gia_km }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ngay_bat_dau" class="form-label">Ngày bắt đầu</label>
                                                <input type="date" class="form-control" name="ngay_bat_dau" value="{{ $khuyenmai->ngay_bat_dau }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ngay_ket_thuc" class="form-label">Ngày kết thúc</label>
                                                <input type="date" class="form-control" name="ngay_ket_thuc" value="{{ $khuyenmai->ngay_ket_thuc }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
