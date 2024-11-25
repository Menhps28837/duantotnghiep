@extends('layout')
@section('title') Chi tiết đơn hàng @endsection
@section('noidungchinh')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    <div class="container mt-5 row">
        <div class="col-8">
            <h1>Chi Tiết Đơn Hàng #{{ $donHang->id }}</h1>
        </div>
        <div class="col-4 text-end mt-2">
            <a class="btn btn-dark btn-sm fs-5" href="/theo-doi-don-hang">Quay lại</a>
        </div>
        <p>Trạng Thái: 
            @if ($donHang->trang_thai == 0)
                Đang chờ xác minh
            @elseif ($donHang->trang_thai == 1)
                Đã xác minh
            @elseif ($donHang->trang_thai == 2)
                Đã hủy
            @elseif ($donHang->trang_thai == 3)
                Đã giao cho shipper
            @elseif ($donHang->trang_thai == 4)
                Đã giao thành công
            @elseif ($donHang->trang_thai == 5)
                Đơn hàng đã được bạn xác nhận
            @elseif ($donHang->trang_thai == 6)
                Đang chờ xử lý (Trả hàng)
            @elseif ($donHang->trang_thai == 7)
                Cho phép (Trả hàng)
            @elseif ($donHang->trang_thai == 8)
                Từ chối (Trả hàng)
            @else
                Không xác định
            @endif
        </p>        
        
        <p> Thanh toán:
            @if ($donHang->trang_thai_thanh_toan == 0)
                Chưa thanh toán
            @elseif ($donHang->trang_thai_thanh_toan == 1)
                Đã thanh toán (chờ xác minh)
            @elseif ($donHang->trang_thai_thanh_toan == 2)
                Đã thanh toán 
            @else
                Không xác định
            @endif
        </p>
        <p>Ngày đặt hàng: {{date('d/m/Y',strtotime($donHang->thoi_diem_mua_hang))}}</p>

        <h2>Chi Tiết Sản Phẩm</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Hình</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->ten_sp }}</td>
                        <td>
                            <img src="{{ $detail->hinh }}" alt="{{ $detail->ten_sp }}" style="width: 100px;">
                        </td>
                        <td>{{ $detail->so_luong }}</td>
                        <td>{{ number_format($detail->gia_km, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($donHang->trang_thai == 0)
            <form action="{{ route('order.cancel', ['id' => $donHang->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                @csrf
                <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
            </form>

        @elseif ($donHang->trang_thai == 1)
            <p class="text-danger">Không thể hủy đơn hàng vì đơn hàng đã được xác nhận.</p>

        @elseif ($donHang->trang_thai == 2)
            <form action="{{ route('order.mualai', ['id' => $donHang->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn mua lại đơn hàng này?');">
                @csrf
                <button type="submit" class="btn btn-success">Mua Lại</button>
            </form>

        @elseif  ($donHang->trang_thai == 3)
            <p class="text-danger">Không thể hủy đơn hàng vì đơn hàng đang được vận chuyển.</p>

        @elseif ($donHang->trang_thai == 4)
            <p class="text-danger">Không thể hủy đơn hàng vì đơn hàng đã được giao thành công.</p>
            <!-- Sử dụng d-flex để căn chỉnh các phần tử trên cùng một hàng -->
            <div class="d-flex justify-content-start gap-3 flex-nowrap align-items-center">
                <!-- Form Mua lại -->
                <form action="{{ route('order.mualai', ['id' => $donHang->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn mua lại đơn hàng này?');">
                    @csrf
                    <button type="submit" class="btn btn-success mt-3">Mua Lại</button>
                </form>
            
                @php
                    $thoiDiemMuaHang = \Carbon\Carbon::parse($donHang->thoi_diem_mua_hang);
                    $checktime = now()->startOfDay()->diffInDays($thoiDiemMuaHang, true) <= 7;
                @endphp
            
                <!-- Nút yêu cầu trả hàng nếu điều kiện đúng -->
                @if ($checktime)
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnModal">Yêu cầu trả hàng</button>
                @else
                    <p class="text-danger">Không thể yêu cầu trả hàng vì đã quá 7 ngày kể từ thời điểm đặt hàng.</p>
                @endif
            </div>
            
            <!-- Modal yêu cầu trả hàng -->
            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('order.trahang', ['id' => $donHang->id]) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="returnModalLabel">Yêu cầu trả hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mt-3">
                                    <label>Vui lòng chọn lý do trả hàng:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Sản phẩm hư hỏng" id="reason1">
                                        <label class="form-check-label" for="reason1">
                                            Sản phẩm hư hỏng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Sản phẩm bị lỗi" id="reason2">
                                        <label class="form-check-label" for="reason2">
                                            Sản phẩm bị lỗi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value=" Không đúng sản phẩm tôi mua" id="reason3">
                                        <label class="form-check-label" for="reason3">
                                            Không đúng sản phẩm tôi mua
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Khác" id="reason4">
                                        <label class="form-check-label" for="reason4">
                                            Khác
                                        </label>
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <label for="lydo">Lý do trả hàng:</label>
                                    <textarea name="lydo" id="lydo" class="form-control" placeholder="Phiền bạn ghi rõ lý do trả hàng để chúng tôi nắm thông tin..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-warning">Gửi yêu cầu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @elseif ($donHang->trang_thai == 5)
            <p class="text-danger">Không thể hủy đơn hàng vì bạn đã xác nhận đơn hàng.</p>

            <div class="d-flex justify-content-start gap-3 flex-nowrap align-items-center">
                <!-- Form Mua lại -->
                <form action="{{ route('order.mualai', ['id' => $donHang->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn mua lại đơn hàng này?');">
                    @csrf
                    <button type="submit" class="btn btn-success mt-3">Mua Lại</button>
                </form>
            
                @php
                    $thoiDiemMuaHang = \Carbon\Carbon::parse($donHang->thoi_diem_mua_hang);
                    $checktime = now()->startOfDay()->diffInDays($thoiDiemMuaHang, true) <= 7;
                @endphp
            
                <!-- Nút yêu cầu trả hàng nếu điều kiện đúng -->
                @if ($checktime)
                    <button type="button" class="btn btn-warning ycth" data-bs-toggle="modal" data-bs-target="#returnModal">Yêu cầu trả hàng</button>
                @else
                    <p class="text-danger">Không thể yêu cầu trả hàng vì đã quá 7 ngày kể từ thời điểm đặt hàng.</p>
                @endif

                <!-- Nút đánh giá sản phẩm -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rateProductModal">Đánh giá sản phẩm</button>

            </div>
            
            <!-- Modal yêu cầu trả hàng -->
            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('order.trahang', ['id' => $donHang->id]) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="returnModalLabel">Yêu cầu trả hàng</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mt-3">
                                    <label>Vui lòng chọn lý do trả hàng:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Sản phẩm hư hỏng" id="reason1">
                                        <label class="form-check-label" for="reason1">
                                            Sản phẩm hư hỏng
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Sản phẩm bị lỗi" id="reason2">
                                        <label class="form-check-label" for="reason2">
                                            Sản phẩm bị lỗi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value=" Không đúng sản phẩm tôi mua" id="reason3">
                                        <label class="form-check-label" for="reason3">
                                            Không đúng sản phẩm tôi mua
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reasons[]" value="Khác" id="reason4">
                                        <label class="form-check-label" for="reason4">
                                            Khác
                                        </label>
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <label for="lydo">Lý do trả hàng:</label>
                                    <textarea name="lydo" id="lydo" class="form-control" placeholder="Phiền bạn ghi rõ lý do trả hàng để chúng tôi nắm thông tin..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-warning">Gửi yêu cầu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal đánh giá sản phẩm -->
            <div class="modal fade" id="rateProductModal" tabindex="-1" aria-labelledby="rateProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('order.danhgia', ['id' => $donHang->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_dh" value="{{ $donHang->id }}">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rateProductModalLabel">Đánh giá sản phẩm</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @foreach($donHang->don_hang_chi_tiets as $orderDetail)
                                    <div class="form-group">
                                        <input type="hidden" name="id_sp[]" value="{{ $orderDetail->id_sp }}">
                                        <label for="rating{{ $orderDetail->id_sp }}">Đánh giá sản phẩm: {{ $orderDetail->ten_sp }}</label>
                                        <select name="rating[]" id="rating{{ $orderDetail->id_sp }}" class="form-control" required>
                                            <option value="0">Tốt</option>
                                            <option value="1">Trung bình</option>
                                            <option value="2">Không tốt</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="comment{{ $orderDetail->id_sp }}">Bình luận cho sản phẩm: {{ $orderDetail->ten_sp }}</label>
                                        <textarea name="comment[]" id="comment{{ $orderDetail->id_sp }}" class="form-control" placeholder="Nhập bình luận của bạn..." required></textarea>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            
            

            
        @elseif ($donHang->trang_thai == 6)
            <p class="text-success">Đơn hàng đã được yêu cầu trả hàng</p>
        @elseif ($donHang->trang_thai == 7)
            <p class="text-success">Đơn hàng đã được cho phép trả hàng</p>
        @elseif ($donHang->trang_thai == 8)
            <p class="text-danger">Đơn hàng không được cho phép trả hàng</p>
        @else
            <form action="{{ route('order.cancel', ['id' => $donHang->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                @csrf
                <button type="submit" class="btn btn-danger">Hủy Đơn Hàng</button>
            </form>
        @endif

        
    </div>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    @endsection