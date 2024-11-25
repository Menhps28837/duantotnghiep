<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<h2 class="bg-dark mt-3 p-2 fs-5 text-white"> Bình luận sản phẩm</h2>

@if (auth()->check())
    <div id="list_binh_luan">
        @foreach($binh_luan_arr as $bl)
            @if ($bl->parent_id == null)  <!-- Nếu là bình luận gốc -->
                <div class="border border-success m-2 p-2" id="comment-{{ $bl->id }}">
                    <p class="d-flex justify-content-between mb-0">
                        <b>{{ $bl->user->name }}</b>
                        <span>{{ gmdate('d/m/Y H:i:s', strtotime($bl->thoi_diem) + 3600 * 7) }}</span>
                    </p>
                    <p>{!! $bl->noi_dung !!}</p>

                    <!-- Nút Trả lời -->
                    <button class="btn btn-info btn-sm reply-btn" data-bl-id="{{ $bl->id }}">Trả lời</button>

                    <!-- Form trả lời dưới bình luận -->
                    <div id="reply-form-{{ $bl->id }}" class="mt-2" style="display:none;">
                        <form class="reply-comment-form" data-parent-id="{{ $bl->id }}">
                            @csrf
                            <textarea name="noi_dung" class="form-control" rows="2" placeholder="Mời bạn nhập bình luận..."></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Gửi trả lời</button>
                        </form>
                    </div>

                    <!-- Hiển thị số lượng trả lời và nút để toggle trả lời -->
                    @php
                        $countReplies = $binh_luan_arr->where('parent_id', $bl->id)->count();
                    @endphp
                    @if ($countReplies > 0)
                        <button class="btn btn-link view-replies-btn" data-bl-id="{{ $bl->id }}">
                            Xem {{ $countReplies }} câu trả lời
                        </button>
                    @endif

                    <!-- Hiển thị các bình luận trả lời -->
                    <div class="replies" id="replies-{{ $bl->id }}" style="display:none;">
                        @foreach($binh_luan_arr->where('parent_id', $bl->id) as $reply)
                            <div class="border border-primary m-2 p-2" style="margin-left: 20px;" id="comment-{{ $reply->id }}">
                                <p class="d-flex justify-content-between">
                                    <b>{{ $reply->user->name }}</b>
                                    <span>{{ gmdate('d/m/Y H:i:s', strtotime($reply->thoi_diem) + 3600 * 7) }}</span>
                                </p>
                                <p>{!! $reply->noi_dung !!}</p>

                                <!-- Nút Trả lời cho bình luận trả lời -->
                                <button class="btn btn-info btn-sm reply-btn" data-bl-id="{{ $reply->id }}">Trả lời</button>

                                <!-- Form trả lời dưới bình luận trả lời -->
                                <div id="reply-form-{{ $reply->id }}" class="mt-2" style="display:none;">
                                    <form class="reply-comment-form" data-parent-id="{{ $reply->id }}">
                                        @csrf
                                        <textarea name="noi_dung" class="form-control" rows="2" placeholder="Mời bạn nhập bình luận..."></textarea>
                                        <button type="submit" class="btn btn-primary mt-2">Gửi trả lời</button>
                                    </form>
                                </div>

                                <!-- Hiển thị các bình luận trả lời tiếp -->
                                <div class="replies" id="replies-{{ $reply->id }}" style="display:block;">
                                    @foreach($binh_luan_arr->where('parent_id', $reply->id) as $sub_reply)
                                        <!-- Trả lời tiếp của bình luận con -->
                                        <div class="border border-info m-2 p-2" style="margin-left: 40px;">
                                            <p class="d-flex justify-content-between">
                                                <b>{{ $sub_reply->user->name }}</b>
                                                <span>{{ gmdate('d/m/Y H:i:s', strtotime($sub_reply->thoi_diem) + 3600 * 7) }}</span>
                                            </p>
                                            <p>{!! $sub_reply->noi_dung !!}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    
    </div>

    <hr>
    <form id="comment-form" class="border border-success p-3">
        @csrf
        <p>
            <textarea style="font-size: 18px" class="form-control shadow-none" 
            name="noi_dung" rows="3" placeholder="Mời nhập bình luận"></textarea>
        </p>
        <p class="text-end">  
            <input type="hidden" name="id_sp" value="{{$sp->id}}">
            <input type="hidden" id="parent_id" name="parent_id" value="">
            <button class="btn btn-success" type="submit">Gửi bình luận</button>
        </p>
    </form>
    
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
@else
    <div class="alert alert-primary" role="alert">
        <strong>Đăng nhập để bình luận </strong> Click vào đây -><a href="{{url('admin/dangnhap')}}">Đăng nhập</a>
    </div>
@endif

<script>
    $(document).ready(function () {
// Xử lý sự kiện "Trả lời" khi người dùng muốn trả lời một bình luận
$(document).on('click', '.reply-btn', function () {
    let parentId = $(this).data('bl-id');  // Lấy ID của bình luận gốc
    let replyForm = $(`#reply-form-${parentId}`); // Lấy form trả lời

    // Hiển thị form trả lời nếu chưa hiển thị, ẩn nếu đã hiển thị
    replyForm.fadeToggle(); // Thay toggle bằng fadeToggle để có hiệu ứng mượt mà
});

// Xử lý sự kiện "Xem/Ẩn câu trả lời"
$(document).on('click', '.view-replies-btn', function () {
    let parentId = $(this).data('bl-id');
    let repliesDiv = $(`#replies-${parentId}`);
    let button = $(this);
    
    // Kiểm tra nếu phần trả lời đang hiển thị
    if (repliesDiv.is(':visible')) {
        // Nếu phần trả lời đang hiển thị, ẩn nó và thay đổi nội dung nút
        repliesDiv.fadeOut();
        button.text(`Xem ${repliesDiv.children().length} câu trả lời`);
    }
    // Nếu phần trả lời đang ẩn
    else if (repliesDiv.is(':hidden')) {
        // Nếu phần trả lời đang ẩn, hiển thị nó và thay đổi nội dung nút
        repliesDiv.fadeIn();
        button.text('Ẩn tất cả câu trả lời');
    }
});


// Xử lý gửi bình luận
$('#comment-form').on('submit', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let id_user = {{ auth()->check() ? auth()->user()->id : 'null' }};

    $.ajax({
        url: `/luubinhluan/${id_user}`,
        method: 'POST',
        data: formData,
        success: function (response) {
            $('#list_binh_luan').append(`
                <div class="border border-success m-2 p-2">
                    <p class="d-flex justify-content-between mb-0">
                        <b>${response.user_name}</b> 
                        <span>${response.thoi_diem}</span>
                    </p>
                    <p>${response.noi_dung}</p>
                </div>
            `);
            $('textarea[name="noi_dung"]').val('');
            
            $('#success-message').text('Đã gửi bình luận!').fadeIn().delay(2000).fadeOut();
        },
        error: function (xhr) {
            let errorMessage = 'Đã có lỗi xảy ra';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            alert(errorMessage);
        }
    });
});

// Xử lý gửi trả lời bình luận
$(document).on('submit', '.reply-comment-form', function (e) {
    e.preventDefault();

    let formData = $(this).serialize();
    let parentId = $(this).data('parent-id');
    let id_user = {{ auth()->check() ? auth()->user()->id : 'null' }};

    let id_sp = $('input[name="id_sp"]').val();

    // Kiểm tra lại id_sp có giá trị hợp lệ không
    if (!id_sp || id_sp === '-1') {
        alert('Sản phẩm không hợp lệ!');
        return;
    }

    // Thêm id_sp vào formData để gửi kèm
    formData += `&id_sp=${id_sp}&parent_id=${parentId}`;

    $.ajax({
        url: `/luubinhluan/${id_user}`,
        method: 'POST',
        data: formData,
        success: function (response) {
             // Hiển thị bình luận trả lời dưới bình luận gốc
            const repliesDiv = $(`#replies-${parentId}`);
            repliesDiv.show(); // Hiển thị phần trả lời nếu chưa hiển thị

             // Thêm bình luận trả lời vào phần trả lời
            repliesDiv.append(`
                <div class="border border-primary m-2 p-2" style="margin-left: 20px;">
                    <p class="d-flex justify-content-between">
                        <b>${response.user_name}</b> 
                        <span>${response.thoi_diem}</span>
                    </p>
                    <p>${response.noi_dung}</p>
                </div>
            `);

            // Reset form trả lời và ẩn form trả lời
            $(`#reply-form-${parentId}`).fadeOut();
            $(`#reply-form-${parentId} textarea`).val('');
            $('#success-message').text('Đã gửi trả lời!').fadeIn().delay(2000).fadeOut();
        },
        error: function (xhr) {
            let errorMessage = 'Đã có lỗi xảy ra';
            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            alert(errorMessage);
        }
    });
});
});
</script>