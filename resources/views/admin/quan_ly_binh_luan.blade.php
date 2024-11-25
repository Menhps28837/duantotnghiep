@extends('admin/layoutadmin')
@section('title') Quản lý bình luận @endsection

@section('noidungchinh')
@if(session()->has('thongbao'))
    <div class="alert alert-danger">{{ session('thongbao') }}</div>
@endif
@if(session()->has('thongbao2'))
    <div class="alert alert-success">{{ session('thongbao2') }}</div>
@endif

<h1>Danh sách bình luận</h1>
@if($binhLuanArr->count() === 0 && request('search'))
    <div class="alert alert-warning">Không tìm thấy bình luận nào với từ khóa "{{ request('search') }}".</div>
@endif
@if($binhLuanArr->count() === 0 && !request('search'))
    <div class="alert alert-info p-3 mx-auto my-3 col-10 fs-5 text-center">
        Chưa có bình luận nào.
    </div>
@else

<form method="GET" action="{{ route('admin.binhluan') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo sản phẩm hoặc tên người dùng..." value="{{ request('search') }}">
        <div class="input-group-append">
            <button class="btn btn-secondary" type="button" onclick="clearSearch()">x</button>
            <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i></button>
        </div>
    </div>
</form>

<script>
    // Hàm toggle ẩn/hiện tất cả trả lời của bình luận gốc
    function toggleAllReplies(binhLuanId) {
        var repliesSection = document.getElementById('all-replies-' + binhLuanId);
        var toggleButton = document.getElementById('toggle-all-btn-' + binhLuanId);
        if (repliesSection.style.display === 'none') {
            repliesSection.style.display = 'block';
            toggleButton.innerText = 'Ẩn tất cả trả lời';
        } else {
            repliesSection.style.display = 'none';
            toggleButton.innerText = 'Hiện tất cả trả lời';
        }
    }

    // Hàm toggle ẩn/hiện trả lời con
    function toggleReplies(replyId) {
        var replySection = document.getElementById('replies-' + replyId);
        var toggleButton = document.getElementById('toggle-btn-' + replyId);
        if (replySection.style.display === 'none') {
            replySection.style.display = 'block';
            toggleButton.innerText = 'Ẩn trả lời';
        } else {
            replySection.style.display = 'none';
            toggleButton.innerText = 'Hiện trả lời';
        }
    }

    // Hàm để hiển thị form trả lời cho bình luận gốc
    function showReplyForm(binhLuanId) {
        var formSection = document.getElementById('form-reply-' + binhLuanId);
        
        // Kiểm tra nếu form trả lời đang hiển thị
        if (formSection.style.display === 'block') {
            // Nếu form đang hiển thị, ẩn nó
            formSection.style.display = 'none';
        } else {
            // Nếu form chưa hiển thị, hiển thị nó
            formSection.style.display = 'block';
        }
    }

    function showReplyFormToGoc(binhLuanId) {
    // Lấy form trả lời của bình luận gốc
    var formSection = document.getElementById('reply-form-' + binhLuanId);

    // Kiểm tra nếu form trả lời đang hiển thị
    if (formSection.style.display === 'block') {
        // Nếu form đang hiển thị, ẩn nó
        formSection.style.display = 'none';
    } else {
        // Nếu form chưa hiển thị, hiển thị nó
        formSection.style.display = 'block';
    }
}
    function showReplyFormToReply(binhLuanId, parentReplyId) {
        var formSection = document.getElementById('reply-form-' + parentReplyId);
        // Kiểm tra nếu form trả lời đang hiển thị
        if (formSection.style.display === 'block') {
            // Nếu form đang hiển thị, ẩn nó
            formSection.style.display = 'none';
        } else {
            // Nếu form chưa hiển thị, hiển thị nó
            formSection.style.display = 'block';
        }
    }
</script>


<table class="table">
    <thead>
        <tr class="text-center">
            <th>Sản phẩm</th>
            <th style="width: 200px">Tên người dùng</th>
            <th style="width: 400px">Nội dung bình luận</th>
            <th>Thời gian</th>
            <th>Hành động</th>
            <th>Xóa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($binhLuanArr as $binhLuan)
            @if ($binhLuan->parent_id == null)
                <tr>
                    <td>{{ $binhLuan->san_pham->ten_sp }}</td>
                    <td>{{ $binhLuan->user->name }}</td>
                    <td>{!! $binhLuan->noi_dung !!}
                        @if ($binhLuan->thoi_diem >= $thoiGianMoi)
                            <span style="font-size: 12px" class="badge bg-info">Mới</span> 
                        @endif
                    </td>
                    <td class="text-center">{{ gmdate('d/m/Y H:i:s', strtotime($binhLuan->thoi_diem) + 3600 * 7) }}</td>

                    <!-- Form trả lời cho bình luận gốc -->
                    <td class="text-center" style="width: 190px">
                        <button class="btn btn-primary" onclick="showReplyForm({{ $binhLuan->id }})">Trả lời</button>

                        <!-- Form trả lời cho bình luận gốc -->
                        <div id="form-reply-{{ $binhLuan->id }}" style="display: none; margin-top: 10px;">
                            <form action="{{ route('admin.traloibinhluan', $binhLuan->id) }}" method="POST">
                                @csrf
                                <textarea name="noi_dung" rows="2" placeholder="Nhập phản hồi..." class="form-control"></textarea>
                                <button type="submit" class="btn btn-primary mt-2 ">Gửi phản hồi</button>
                            </form>
                        </div>
                    </td>

                    <td class="text-center mb-5">
                        <form action="{{ route('admin.binhluan.xoa', $binhLuan->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xác nhận xóa bình luận này')" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                    @if($binhLuan->replies->count() > 0)
                        <tr>
                            <td colspan="6" class="text-center">
                                <button id="toggle-all-btn-{{ $binhLuan->id }}" class="btn btn-info" onclick="toggleAllReplies({{ $binhLuan->id }})">
                                    Hiện tất cả trả lời ({{ $binhLuan->replies->count() }})
                                </button>
                            </td>
                        </tr>

                        <!-- Hiển thị tất cả trả lời của bình luận gốc -->
                        <tr>
                            <td colspan="6">
                                <div id="all-replies-{{ $binhLuan->id }}" style="display: none;">
                                    @foreach($binhLuanArr->where('parent_id', $binhLuan->id) as $reply)
                                <div class="border border-primary m-2 p-2" style="margin-left: 20px;" id="comment-{{ $reply->id }}">
                                    <p class="d-flex justify-content-between">
                                        <b>{{ $reply->user->name }}</b>
                                        <span>{{ gmdate('d/m/Y H:i:s', strtotime($reply->thoi_diem) + 3600 * 7) }}</span>
                                    </p>
                                    <p>{!! $reply->noi_dung !!}
                                        @if ($binhLuan->thoi_diem >= $thoiGianMoi)
                                            <span style="font-size: 12px" class="badge bg-info">Mới</span> 
                                        @endif
                                    </p>

                                    <!-- Nút Trả lời cho bình luận trả lời -->
                                    <button class="btn btn-info btn-sm reply-btn" onclick="showReplyFormToGoc({{ $reply->id }})">Trả lời</button>

                                    <!-- Form trả lời dưới bình luận trả lời -->
                                    <div id="reply-form-{{ $reply->id }}" class="mt-2" style="display:none;">
                                        <form class="reply-comment-form" action="{{ route('admin.traloibinhluan', $reply->id) }}" method="POST">
                                            @csrf
                                            <textarea name="noi_dung" class="form-control" rows="2" placeholder="Mời bạn nhập bình luận..."></textarea>
                                            <button type="submit" class="btn btn-primary mt-2">Gửi trả lời</button>
                                        </form>
                                    </div>
                                    

                                    <!-- Hiển thị các bình luận trả lời tiếp -->
                                    <div class="replies" id="replies-{{ $reply->id }}" style="display:block;">
                                        @foreach($binhLuanArr->where('parent_id', $reply->id) as $sub_reply)
                                            <!-- Trả lời tiếp của bình luận con -->
                                            <div class="border border-info m-2 p-2" style="margin-left: 40px;">
                                                <p class="d-flex justify-content-between">
                                                    <b>{{ $sub_reply->user->name }}</b>
                                                    <span>{{ gmdate('d/m/Y H:i:s', strtotime($sub_reply->thoi_diem) + 3600 * 7) }}</span>
                                                </p>
                                                <p>{!! $sub_reply->noi_dung !!}
                                                    @if ($binhLuan->thoi_diem >= $thoiGianMoi)
                                                        <span style="font-size: 12px" class="badge bg-info">Mới</span> 
                                                    @endif
                                                </p>

                                                <button class="btn btn-info btn-sm reply-btn" onclick="showReplyFormToReply({{ $reply->id }}, {{ $sub_reply->id }})">Trả lời</button>

                                                <!-- Form trả lời dưới bình luận trả lời -->
                                                <div id="reply-form-{{ $sub_reply->id }}" class="mt-2" style="display:none;">
                                                    <form action="{{ route('admin.traloibinhluan', $sub_reply->id) }}" method="POST" class="reply-comment-form">
                                                        @csrf
                                                        <textarea name="noi_dung" class="form-control" rows="2" placeholder="Mời bạn nhập bình luận..."></textarea>
                                                        <button type="submit" class="btn btn-primary mt-2">Gửi trả lời</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif
                </tr>

            @endif
        @endforeach
    </tbody>
</table>



<div class="p-2 d-flex justify-content-center">{{$binhLuanArr->links() }}</div>

@endif
@endsection
