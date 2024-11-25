<html>

<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="/css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  @stack('css')
  @stack('javascript1')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <header class="position-relative">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
      <div class="container w-100">
        <div class="row w-100 align-items-center">
          <!-- Logo (2 phần) -->
          <div class="col-3 text-start">
            <a href="{{ url('/') }}" class="navbar-brand">
              <img class="logo" src="/images/Logo.jpg" id="logo" alt="Logo">
            </a>
          </div>
  
          <!-- Navbar Links (6 phần) -->
          <div class="col-6">
            <form method="GET" action="{{ route('sanpham.timkiem') }}" class="mt-3">
              <div class="input-group">
                <input type="text" name="search" class="form-control inputtimkiem"
                  placeholder="Tìm kiếm loại, tên sản phẩm ..." value="{{ request('search') }}">
                <div class="input-group-append">
                  <button class="btn btn-primary inputtim" type="submit"><i style="font-size: 23px" class="bi bi-search"></i></button>
                </div>
              </div>
            </form>
         
  
            <!-- Tạo phần Hamburger Menu khi màn hình nhỏ -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
    
            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
              
              <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-between nav">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('gioithieu') }}">Giới Thiệu</a>
                </li>
                <li class="nav-item dropdown-danh-muc">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Danh Mục
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($loai_arr as $lt)
                      <li><a style="color: black" class="dropdown-item" href="/loai/{{$lt->id}}">{{$lt->ten_loai}}</a></li>
                    @endforeach
                  </ul>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('tin_tucs.index') }}">Tin tức</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/lienhe') }}">Liên Hệ</a>
                </li>
                @if (Auth::check())
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.donhang.order.tracking.index') }}">Theo dõi đơn hàng</a>
                  </li>
                @endif
              </ul>
            </div>
          </div>
       
  
        <!-- Search, Cart, and Account (2 phần) -->
        <div class="col-3 d-flex justify-content-end align-items-center">
          <!-- Cart Icon -->
          <div id="giohang" class="me-3">
            <a href="/hiengiohang" class="text-white position-relative">
              <i class="fas fa-cart-plus itemgiohang"></i>
              <span class="badge bg-danger position-absolute top-0 start-100 translate-middle sogiohang" id="cart-count">
                {{ session('cart') ? count(session('cart')) : 0 }}
              </span>
            </a>
          </div>
  
          <!-- Account Section -->
          <div class="dropdown">
            @if (auth()->check())
              @if (Auth::user()->role == 1)  <!-- Kiểm tra nếu người dùng là admin -->
                <a href="{{ url('/admin') }}" class="text-white text-decoration-none me-2">
                  {{ Auth::user()->name }}
                </a>
              @else
                <a href="{{ url('/user/' . Auth::user()->id) }}" class="text-white text-decoration-none me-2">
                  {{ Auth::user()->name }}
                </a>
              @endif
              <a href="{{ url('/thoat') }}" class="text-decoration-none text-white">Thoát</a>
            @else
              <a href="#" class="text-white text-decoration-none dropdown-toggle taikhoan" data-bs-toggle="dropdown" aria-expanded="false">Tài khoản</a>
              <ul style="right: -75%" class="dropdown-menu dropdown-menu-end">
                <li><a style="font-size: 16px" class="dropdown-item" href="{{ url('/admin/dangnhap') }}">Đăng nhập</a></li>
                <li><a style="font-size: 16px" class="dropdown-item" href="{{ url('/dangky') }}">Đăng ký</a></li>
              </ul>
            @endif
          </div>
        </div>
      </div>
      </div>
  
      <!-- Success Notification -->
      @if(session()->has('thongbaothem'))
      <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3 p-2" role="alert" style="width: 300px;">
        {!! session('thongbaothem') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
    </nav>

    {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">Website</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="#">Trang chủ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Dịch vụ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Giới thiệu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Liên hệ</a>
          </li>
        </ul>
      </div>
    </nav> --}}
  </header>
  
<script>
    // Khi nhấn vào icon tìm kiếm, sẽ hiển thị form tìm kiếm
    document.getElementById('search-icon').addEventListener('click', function() {
        this.classList.toggle('active');
        document.getElementById('search-form').classList.toggle('d-block');
    });
</script>


  <div class="container">
    <main>
      @yield('noidungchinh')   

      <div class="floating-icons">
        <a href="https://www.facebook.com/tieu.anh.cuong/" target="_blank" class="icon facebook" title="Facebook">
          <img src="/images/facebook.png" alt="Facebook">
        </a>
        <a href="https://zalo.me" target="_blank" class="icon zalo" title="Zalo">
          <img src="/images/zalo.png" alt="Zalo">
        </a>
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          const floatingIcons = document.querySelector('.floating-icons');
          const homePageUrl = '/'; // Đường dẫn trang chủ

          const isCategoryPage = window.location.pathname.startsWith('/loai/');

          if (window.location.pathname !== homePageUrl && !isCategoryPage) {
            floatingIcons.style.display = 'none'; // Ẩn biểu tượng trên các trang khác
          }
        });

        // Hàm gọi khi thêm sản phẩm vào giỏ hàng
        function addToCart(id_sp, soluong) {
          // Hiển thị thông báo xác nhận trước khi thêm vào giỏ hàng
          Swal.fire({
            title: 'Bạn có chắc chắn muốn thêm sản phẩm này vào giỏ hàng?',
            text: "Sản phẩm sẽ được thêm vào giỏ hàng của bạn.",
            icon: 'question',
            showCancelButton: true, // Hiển thị nút Cancel
            confirmButtonColor: '#3085d6', // Màu sắc nút "OK"
            cancelButtonColor: '#d33', // Màu sắc nút "Cancel"
            confirmButtonText: 'Thêm vào giỏ hàng',
            cancelButtonText: 'Hủy'
          }).then((result) => {
            if (result.isConfirmed) {
              // Tiến hành thêm sản phẩm vào giỏ hàng khi người dùng xác nhận
              fetch(`/themvaogio/${id_sp}/${soluong}`, {
                method: 'GET',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
              })
                .then(response => response.json())
                .then(data => {
                  if (data.error) {
                    // Nếu có lỗi, hiển thị thông báo lỗi
                    Swal.fire({
                      icon: 'error',
                      title: 'Có lỗi xảy ra!',
                      text: data.error,
                      showConfirmButton: true
                    });
                    return;
                  }

                  // Hiển thị thông báo thành công khi thêm vào giỏ hàng
                  Swal.fire({
                    icon: 'success',
                    title: 'Sản phẩm đã được thêm vào giỏ hàng!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500 // Thời gian tự động đóng sau 1,5 giây
                  });

                  // Cập nhật số lượng giỏ hàng trên giao diện
                  let cartCountElement = document.getElementById('cart-count');
                  if (data.cart_count !== null) {
                    cartCountElement.textContent = data.cart_count; // Cập nhật số lượng sản phẩm trong giỏ hàng
                  }

                })
                .catch(error => {
                  Swal.fire({
                    icon: 'error',
                    title: 'Có lỗi xảy ra',
                    text: 'Vui lòng thử lại sau.',
                    showConfirmButton: true
                  });
                  console.error('Error:', error);
                });
            }
          });
        }

      </script>

    </main>
  </div>

  <footer class="mb-5">
    <div style="border-top: 1px solid rgb(189, 189, 189) ;" class="container-fluid col-sm-12 mt-4 ">
      <div class="container mt-3">
        <div class="row">
          <div class="col-sm-3">
            <li class="list-group-item pb-3">Tích điểm Quà tặng VIP</li>
            <li class="list-group-item pb-3">Lịch sử mua hàng</li>
            <li class="list-group-item pb-3">Tìm hiểu về mua trả góp</li>
            <li class="list-group-item pb-3">Chính sách bảo hành</li>
            <li class="list-group-item pb-3">Xem thêm </li>

          </div>
          <div class="col-sm-3">
            <li class="list-group-item pb-3">Giới thiệu công ty (MWG.vn)</li>
            <li class="list-group-item pb-3">Tuyển dụng</li>
            <li class="list-group-item pb-3">Gửi góp ý, khiếu nại</li>
            <li class="list-group-item pb-3">Tìm siêu thị (3.164 shop)</li>
            <li class="list-group-item pb-3">Xem bản mobile</li>
          </div>
          <div class="col-sm-3">
            <li class="list-group-item pb-3"><b>Tổng đài hỗ trợ</b></li>
            <li class="list-group-item pb-3">Gọi mua: <span style="color: blue;">1900 232 460 </span> (7:30 - 22:00)
            </li>
            <li class="list-group-item pb-3">Khiếu nại: <span style="color: blue;">1800.1062 </span> (8:00 - 21:30)</li>
            <li class="list-group-item pb-3">Bảo hành: <span style="color: blue;">1900 232 464 </span> (8:00 - 21:00)
            </li>
          </div>
          <div class="col-sm-3 fs-5">
            Website cùng tập đoàn
            <i><img src="/images/Logo-cungtapdoan.webp" alt="" width="300px" height="230px"></i>
          </div>
        </div>
      </div>
      <div class="container-fluid ">
        <div class="container text-center">
          © 2018. Công ty cổ phần MobiCenter.
          {{-- <span>Xem chính sách sử dụng</span> --}}
        </div>
      </div>
    </div>
  </footer>
  </div>
  <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>

  <script>
    // Kiểm tra session-id khi tải trang
    document.addEventListener("DOMContentLoaded", function () {
      let sessionId = localStorage.getItem('chat-session-id');

      if (!sessionId) {
        // Tạo session ID nếu chưa có
        sessionId = 'chat-session-' + new Date().getTime();
        localStorage.setItem('chat-session-id', sessionId);
      }

      // Thiết lập session-id cho df-messenger
      const dfMessenger = document.querySelector('df-messenger');
      dfMessenger.setAttribute('session-id', sessionId);

      console.log("Session ID:", sessionId);

      // Khôi phục lịch sử trò chuyện khi tải lại trang
      restoreChatHistory();
    });

    // Lưu lịch sử câu hỏi và câu trả lời
    function saveChatHistory(question, answer) {
      let chatHistory = JSON.parse(localStorage.getItem('chat-history')) || [];
      chatHistory.push({ question, answer });
      localStorage.setItem('chat-history', JSON.stringify(chatHistory));
    }

    // Khôi phục lịch sử câu hỏi và câu trả lời
    function restoreChatHistory() {
      let chatHistory = JSON.parse(localStorage.getItem('chat-history')) || [];
      chatHistory.forEach(chat => {
        // Gửi lại câu hỏi và trả lời đã lưu trước đó
        setTimeout(() => {
          sendMessageToChatbot(chat.question);
        }, 1000); // Delay để tạo hiệu ứng trước khi gửi câu hỏi
        setTimeout(() => {
          sendMessageToChatbot(chat.answer);
        }, 2000); // Delay để trả lời sau câu hỏi
      });
    }

    // Gửi câu hỏi và câu trả lời vào chatbot
    function sendMessageToChatbot(message) {
      const event = new CustomEvent('sendMessage', {
        detail: { message: message }
      });
      document.querySelector('df-messenger').dispatchEvent(event);
    }

    // Lắng nghe sự kiện gửi câu hỏi từ người dùng
    document.querySelector('df-messenger').addEventListener('df-message-sent', function (e) {
      const userMessage = e.detail.message;
      const chatbotAnswer = "Câu trả lời từ chatbot"; // Đây là câu trả lời giả lập

      // Lưu câu hỏi và câu trả lời vào localStorage
      saveChatHistory(userMessage, chatbotAnswer);
    });
  </script>

  <df-messenger intent="WELCOME" chat-title="chatbot" agent-id="d0a2a551-2787-402f-8b9a-b4a043f8699a" language-code="vi"
    session-id="chat-session-id"></df-messenger>


</body>

</html>
@stack('javascript2')