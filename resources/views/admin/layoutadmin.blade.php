@if (Auth()->check())
  @if (Auth::user()->role == 1)
    <head> <meta charset="utf-8">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
      {{-- <link rel="stylesheet" href="/css/sb-admin-2.css"> --}}

      {{-- <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> --}}
      <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
      <link href="/css/sb-admin-2.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/css/styleadmin.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

      <title> @yield('title')</title>
      </head>
      <body>
        <div class="container-fuild">
          {{-- <nav> 
            <nav class="navbar navbar-expand-lg bg-success" data-bs-theme="dark">
              <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" href="/admin">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"> 
                      Quản lý loại 
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/loai/create">Thêm loại</a></li>
                        <li><a class="dropdown-item" href="/admin/loai">Danh sách loại</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Quản lý sản phẩm
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/sanpham/create">Thêm sản phẩm</a></li>
                        <li><a class="dropdown-item" href="/admin/sanpham">Danh sách sản phẩm</a></li>
                        <li><a class="dropdown-item" href="{{route('admin.khuyenmai')}}">Danh sách sản phẩm khuyến mãi</a></li>
                        <li><a class="dropdown-item" href="{{ route('sanpham.canh_bao') }}">Danh sách sản phẩm sắp hết hàng</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Quản lý đơn hàng
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/donhang">Danh sách đơn hàng</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangxacnhan">Danh sách đơn hàng đã xác nhận</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangdahuy">Đơn hàng đã hủy</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangquashipper">Đơn hàng đã qua shipper</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangdaxong">Đơn hàng đã giao thành công</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Quản lý trả hàng
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/donhangtralai">Đơn hàng yêu cầu trả lại</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangdachopheptralai">Đơn hàng cho phép trả lại</a></li>
                        <li><a class="dropdown-item" href="/admin/donhangdatuchoi">Đơn hàng từ chối trả lại</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Quản lý User
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/user/create">Thêm user</a></li>
                        <li><a class="dropdown-item" href="/admin/user">Danh sách user</a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Quản lý liên hệ
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.lienhe') }}">Danh sách liên hệ</a></li>
                      </ul>
                    </li>
                    @if( Auth::guard('admin')->check()) 
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Chào {{Auth::guard('admin')->user()->name}}
                      </a>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{url('admin/thoat')}}">Thoát</a></li>
                      </ul>
                    </li>
                    @endif
                  </ul>
                </div>
              </div>
            </nav>
          </nav> --}}
          <main>  
            <div class="row">
              <div class="col-2" id="col1">
                <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    
                  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                      <img class="logo" src="/images/Logo.jpg" id="logo" alt="Logo">
                  </a>
    
                  <hr class="sidebar-divider my-0">
      
                  <li class="nav-item active">
                    <a class="nav-link" href="/admin">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Trang Chủ</span>
                    </a>
                  </li>
                  
                  <!-- Quản lý loại -->
                  <li class="nav-item">
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-folder"></i>
                          <span>Quản lý loại</span>
                          <i class="fas fa-angle-right float-end"></i>
                      </a>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                          <div class="bg-white py-2 collapse-inner rounded">
                              <h6 class="collapse-header">Chức năng:</h6>
                              <a class="collapse-item" href="/admin/loai/create">Thêm loại</a>
                              <a class="collapse-item" href="/admin/loai">Danh sách loại</a>
                          </div>
                      </div>
                  </li>
          
                  <!-- Quản lý sản phẩm -->
                  <li class="nav-item">
                      <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-folder"></i>
                          <span>Quản lý sản phẩm</span>
                          <i class="fas fa-angle-right float-end"></i>
                      </a>
                      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                          <div class="bg-white py-2 collapse-inner rounded">
                              <h6 class="collapse-header">Chức năng:</h6>
                              <a class="collapse-item" href="/admin/sanpham/create">Thêm sản phẩm</a>
                              <a class="collapse-item" href="/admin/sanpham">Danh sách sản phẩm</a>
                              {{-- <a class="collapse-item" href="{{route('admin.khuyenmai')}}">Danh sách sản phẩm khuyến mãi</a> --}}
                              <a class="collapse-item" href="{{ route('sanpham.canh_bao') }}">Sản phẩm sắp hết hàng</a>
                          </div>
                      </div>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý đơn hàng</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="/admin/donhang">Danh sách đơn hàng</a>
                            <a class="collapse-item" href="/admin/donhangxacnhan">Đơn hàng đã xác nhận</a>
                            <a class="collapse-item" href="/admin/donhangdahuy">Đơn hàng đã hủy</a>
                            <a class="collapse-item" href="/admin/donhangquashipper">Đơn hàng qua shipper</a>
                            <a class="collapse-item" href="/admin/donhangdaxong">Đơn hàng đã giao xong</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages1" aria-expanded="false" aria-controls="collapsePages1">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý trả hàng</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages1" class="collapse" aria-labelledby="headingPages1" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="/admin/donhangtralai">Đơn hàng yêu cầu trả lại</a>
                            <a class="collapse-item" href="/admin/donhangdachopheptralai">Đơn hàng cho phép trả lại</a>
                            <a class="collapse-item" href="/admin/donhangdatuchoi">Đơn hàng từ chối trả lại</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages2" aria-expanded="false" aria-controls="collapsePages2">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý User</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages2" class="collapse" aria-labelledby="headingPages2" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="/admin/user/create">Thêm user</a>
                            <a class="collapse-item" href="/admin/user">Danh sách user</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages3" aria-expanded="false" aria-controls="collapsePages3">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý liên hệ</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages3" class="collapse" aria-labelledby="headingPages3" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="{{ route('admin.lienhe') }}">Danh sách liên hệ</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages4" aria-expanded="false" aria-controls="collapsePages4">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý bình luận</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages4" class="collapse" aria-labelledby="headingPages4" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="{{ route('admin.binhluan')}}">Danh sách bình luận</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages5" aria-expanded="false" aria-controls="collapsePages5">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý tin tức</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages5" class="collapse" aria-labelledby="headingPages5" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="{{ route('admin.tin_tuc.index')}}">Danh sách tin tức</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages6" aria-expanded="false" aria-controls="collapsePages6">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý đánh giá</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages6" class="collapse" aria-labelledby="headingPages6" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="{{ route('admin.danhgia_ds')}}">Danh sách đánh giá</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages7" aria-expanded="false" aria-controls="collapsePages7">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Quản lý doanh thu</span>
                        <i class="fas fa-angle-right float-end"></i>
                    </a>
                    <div id="collapsePages7" class="collapse" aria-labelledby="headingPages7" data-bs-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Chức năng:</h6>
                            <a class="collapse-item" href="{{ route('admin.doanhthu')}}">Danh sách doanh thu</a>
                        </div>
                    </div>
                </li>
                
      
                 
                  <div class="text-center d-none d-md-inline">
                      <button class="rounded-circle border-0" id="sidebarToggle"></button>
                  </div>
      
                </ul>
              </div>
         
            
              <div class="col-10" id="col2">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    
                  {{-- <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                      <i class="fa fa-bars"></i>
                  </button> --}}

                  {{-- <form
                      class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                      <div class="input-group">
                          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                              aria-label="Search" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                              <button class="btn btn-primary" type="button">
                                  <i class="fas fa-search fa-sm"></i>
                              </button>
                          </div>
                      </div>
                  </form> --}}

                  <ul class="navbar-nav ml-auto">

                    {{-- <form class="form-inline mr-auto w-100 navbar-search" id="searchForm" method="GET" action="{{ route('admin.search') }}">
                      <div class="input-group">
                          <input type="text" name="query" class="form-control bg-light border-0 small" id="searchInput"
                                 placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">
                                  <i class="fas fa-search fa-sm"></i>
                              </button>
                          </div>
                      </div>
                  </form> --}}
                  

                      {{-- <li class="nav-item dropdown no-arrow d-sm-none">
                          <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                              <i class="fas fa-search fa-fw"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                              aria-labelledby="searchDropdown">
                              <form class="form-inline mr-auto w-100 navbar-search" id="searchForm">
                                  <div class="input-group">
                                      <input type="text" class="form-control bg-light border-0 small" id="searchInput"
                                          placeholder="Search for..." aria-label="Search"
                                          aria-describedby="basic-addon2">
                                      <div class="input-group-append">
                                          <button class="btn btn-primary" type="button">
                                              <i class="fas fa-search fa-sm"></i>
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </li> --}}
                      <script>
                        document.getElementById('searchForm').addEventListener('submit', function(event) {
                            event.preventDefault(); // Ngăn không cho form gửi đi theo cách mặc định
                            
                            const query = document.getElementById('searchInput').value;
                            if (query) {
                                // Chuyển hướng đến trang tìm kiếm với query
                                window.location.href = `/search?query=${encodeURIComponent(query)}`;
                            }
                        });
                    </script>
                    

                      {{-- <li class="nav-item dropdown no-arrow mx-1">
                          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                              <i class="fas fa-bell fa-fw"></i>
                              <span class="badge badge-danger badge-counter">3+</span>
                          </a>
                          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                              aria-labelledby="alertsDropdown">
                              <h6 class="dropdown-header">
                                  Alerts Center
                              </h6>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="mr-3">
                                      <div class="icon-circle bg-primary">
                                          <i class="fas fa-file-alt text-white"></i>
                                      </div>
                                  </div>
                                  <div>
                                      <div class="small text-gray-500">December 12, 2019</div>
                                      <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                  </div>
                              </a>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="mr-3">
                                      <div class="icon-circle bg-success">
                                          <i class="fas fa-donate text-white"></i>
                                      </div>
                                  </div>
                                  <div>
                                      <div class="small text-gray-500">December 7, 2019</div>
                                      $290.29 has been deposited into your account!
                                  </div>
                              </a>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="mr-3">
                                      <div class="icon-circle bg-warning">
                                          <i class="fas fa-exclamation-triangle text-white"></i>
                                      </div>
                                  </div>
                                  <div>
                                      <div class="small text-gray-500">December 2, 2019</div>
                                      Spending Alert: We've noticed unusually high spending for your account.
                                  </div>
                              </a>
                              <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                          </div>
                      </li> --}}

                      {{-- <li class="nav-item dropdown no-arrow mx-1">
                          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-envelope fa-fw"></i>
                              <!-- Counter - Messages -->
                              <span class="badge badge-danger badge-counter">7</span>
                          </a>
                          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                              aria-labelledby="messagesDropdown">
                              <h6 class="dropdown-header">
                                  Message Center
                              </h6>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="dropdown-list-image mr-3">
                                      <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                          alt="...">
                                      <div class="status-indicator bg-success"></div>
                                  </div>
                                  <div class="font-weight-bold">
                                      <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                          problem I've been having.</div>
                                      <div class="small text-gray-500">Emily Fowler · 58m</div>
                                  </div>
                              </a>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="dropdown-list-image mr-3">
                                      <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                          alt="...">
                                      <div class="status-indicator"></div>
                                  </div>
                                  <div>
                                      <div class="text-truncate">I have the photos that you ordered last month, how
                                          would you like them sent to you?</div>
                                      <div class="small text-gray-500">Jae Chun · 1d</div>
                                  </div>
                              </a>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="dropdown-list-image mr-3">
                                      <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                          alt="...">
                                      <div class="status-indicator bg-warning"></div>
                                  </div>
                                  <div>
                                      <div class="text-truncate">Last month's report looks great, I am very happy with
                                          the progress so far, keep up the good work!</div>
                                      <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                  </div>
                              </a>
                              <a class="dropdown-item d-flex align-items-center" href="#">
                                  <div class="dropdown-list-image mr-3">
                                      <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                          alt="...">
                                      <div class="status-indicator bg-success"></div>
                                  </div>
                                  <div>
                                      <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                          told me that people say this to all dogs, even if they aren't good...</div>
                                      <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                  </div>
                              </a>
                              <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                          </div>
                      </li> --}}

                      {{-- <div class="topbar-divider d-none d-sm-block"></div> --}}

                      {{-- @if( Auth::guard('admin')->check()) 
                      <li class="nav-item dropdown no-arrow">
                          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Chào {{Auth::guard('admin')->user()->name}}

                      
                          </a>
                          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                              aria-labelledby="userDropdown">
                              <a class="dropdown-item" href="#">
                                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Profile
                              </a>
                              <a class="dropdown-item" href="#">
                                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Settings
                              </a>
                              <a class="dropdown-item" href="#">
                                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Activity Log
                              </a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{url('admin/thoat')}}" data-toggle="modal" data-target="#logoutModal">
                                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                  Thoát
                              </a>
                          </div>
                      </li>
                      @endif --}}


                        <div class="text-end position-relative">
                            <i class="fas fa-bell"  data-bs-toggle="modal" data-bs-target="#notificationModal"></i>
                            @if($tongtatca > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger sothongbao">
                                    {{ $tongtatca }}
                                </span>
                            @endif
                        </div>
                        <!-- Modal thông báo -->
                        <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notificationModalLabel">Thông báo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      @if(!empty($canh_bao_san_pham))
                                          <h6>Cảnh báo sản phẩm:</h6>
                                          <ul>
                                              @foreach ($canh_bao_san_pham as $canh_bao)
                                                  <li>{!! $canh_bao !!}</li>
                                              @endforeach
                                          </ul>
                                          <hr>
                                      @endif
                                      @if(!empty(session()->get('canh_bao_khach_hang_moi')))
                                        <h6>Thông báo khách hàng mới:</h6>
                                        <ul>
                                            @foreach (session()->get('canh_bao_khach_hang_moi') as $canh_bao)
                                                <li>
                                                    {!! $canh_bao !!}
                                                    <a href="/admin/user">Xem</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                      @endif
                                      @if(!empty(session()->get('canh_bao_binh_luan_moi')))
                                        <h6>Thông báo bình luận mới:</h6>
                                        <ul>
                                            @foreach (session()->get('canh_bao_binh_luan_moi') as $canh_bao)
                                                <li>
                                                    {!! $canh_bao !!}
                                                    {{-- <form action="{{ route('admin.notification.delete') }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link" onclick="return confirm('Bạn có chắc muốn xóa thông báo này không?')">Xóa</button>
                                                    </form> --}}
                                                    <a href="{{ route('admin.binhluan')}}">Xem</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                      @endif
                                      @if(!empty($canh_bao_lien_he_moi))
                                        <h6>Thông báo liên hệ mới:</h6>
                                        <ul>
                                            @foreach ($canh_bao_lien_he_moi as $canh_bao)
                                                <li>{!! $canh_bao !!}
                                                <a href="{{ route('admin.lienhe')}}">Xem</a>

                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                      @endif
                                      @if(!empty($canh_bao_danh_gia_moi))
                                        <h6>Thông báo đánh giá mới:</h6>
                                        <ul>
                                            @foreach ($canh_bao_danh_gia_moi as $canh_bao)
                                                <li>{!! $canh_bao !!}
                                                <a href="{{ route('admin.danhgia_ds')}}">Xem</a>

                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr>
                                      @endif

                                        @if(session()->has('canh_bao_don_hang_moi'))
                                          <h6>Thông báo đơn hàng mới:</h6>
                                          <ul>
                                              @foreach (session('canh_bao_don_hang_moi') as $canh_bao)
                                                  <li>{!! $canh_bao !!}
                                                      <a href="/admin/donhang">Xem</a>
                                                  </li>
                                              @endforeach
                                          </ul>
                                          <hr>
                                        @endif
                                  
                                      @if(!empty($canh_bao_tra_hang))
                                          <h6>Thông báo yêu cầu trả hàng:</h6>
                                          <ul>
                                              @foreach ($canh_bao_tra_hang as $canh_bao)
                                                  <li>{!! $canh_bao !!}</li>
                                              @endforeach
                                              <br>
                                              <a href="{{route('donhang.tralai')}}">Danh sách yêu cầu trả hàng</a>
                                          </ul>
                                          <hr>
                                      @endif
                                  
                                     
                                  
                                      @if(empty($canh_bao_san_pham) && empty($canh_bao_tra_hang) && empty($canh_bao_khach_hang_moi) && empty($canh_bao_don_hang_moi) && empty($canh_bao_lien_he_moi))
                                          <p>Không có thông báo nào.</p>
                                      @endif
                                  </div>
                                  
                                </div>
                            </div>
                      </div>
                        {{-- <style>
                        .modal-content {
                            background-color: #fff; /* Màu trắng */
                            border: 1px solid #dee2e6; /* Màu viền nhẹ */
                        }

                        .modal-header {
                            border-bottom: 1px solid #dee2e6; /* Viền dưới */
                        }

                        .modal-footer {
                            border-top: 1px solid #dee2e6; /* Viền trên */
                        }
                        .badge {
                            font-size: 10px; 
                            padding: 5px; 
                            min-width: 10px; 
                            text-align: center; 
                        }
                        </style> --}}
                    <div class="topbar-divider d-none d-sm-block"></div>
                      @if( Auth::guard('admin')->check()) 
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle tenadmin" href="#" role="button" data-bs-toggle="dropdown">
                          Chào {{Auth::guard('admin')->user()->name}}
                        </a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="{{url('admin/thoat')}}">Thoát</a></li>
                        </ul>
                      </li>
                      @endif


                  </ul>

                </nav>
                @yield('noidungchinh')
              </div>
            </div>
            
            {{-- <script>
              document.getElementById('sidebarToggle').addEventListener('click', function () {
                const sidebar = document.getElementById('accordionSidebar');
                sidebar.classList.toggle('toggled');
                });
              </script> --}}

              {{-- <x-dongmenu></x-dongmenu> --}}
              
              {{-- <script src="/js/demo/dongmenu.js"></script> --}}

              {{-- <script>
                document.getElementById('sidebarToggle').addEventListener('click', function() {
                    const col1 = document.getElementById('col1');
                    const col2 = document.getElementById('col2');
        
                    // Thay đổi lớp cột
                    if (col1.classList.contains('col-2')) {
                        col1.classList.remove('col-2');
                        col1.classList.add('col-1');
                        col2.classList.remove('col-10');
                        col2.classList.add('col-11');
                    } else {
                        col1.classList.remove('col-1');
                        col1.classList.add('col-2');
                        col2.classList.remove('col-11');
                        col2.classList.add('col-10');
                    }
                });
            </script> --}}
              
      

             <!-- Bootstrap core JavaScript-->
          <script src="/vendor/jquery/jquery.min.js"></script>
          <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

          <!-- Core plugin JavaScript-->
          <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

          <!-- Custom scripts for all pages-->
          <script src="/js/sb-admin-2.min.js"></script>

          <!-- Page level plugins -->
          <script src="/vendor/chart.js/Chart.min.js"></script>

          <!-- Page level custom scripts -->
          <script src="/js/demo/chart-area-demo.js"></script>
          <script src="/js/demo/chart-pie-demo.js"></script>

          </main>

          


        </div> 
      </body>
  

  @endif
  @else    
  <html>

  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="/css/style.css" rel="stylesheet">
    @stack('css')
    @stack('javascript1')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  
  <body>
    <header class='position-relative'>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fw-bold">
        <div class="container w-75">
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
                    {{-- <button class="btn btn-secondary" type="button" onclick="clearSearch()">x</button> --}}
                    <button class="btn btn-primary inputtim" type="submit">Tìm</button>
                  </div>
                </div>
              </form>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex justify-content-between nav">
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Trang chủ</a>
                  </li> -->
                  <li class="nav-item ">
                    <a class="nav-link" href="{{route ('gioithieu')}}">Giới Thiệu</a>
                  </li>
                  <li class="nav-item dropdown-danh-muc">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Danh Mục
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      @foreach($loai_arr as $lt)
              <li><a style="color: black" class="dropdown-item" href="/loai/{{$lt->id}}">{{$lt->ten_loai}}</a>
              </li>
            @endforeach
                    </ul>
                  </li>
  
                  <li class="nav-item ">
                    <a class="nav-link" href="{{ route('tin_tucs.index')}}">Tin tức</a>
                  </li>
                  <li class="nav-item ">
                    <a class="nav-link" href="{{ url('/lienhe') }}">Liên Hệ</a>
                  </li>
                  @if (Auth::check())
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('user.donhang.order.tracking.index') }}">Theo dõi đơn hàng</a>
            </li>
          @endif
                </ul>
              </div>
            </div>
            <style>
              .navbar-nav .nav-item {
                white-space: nowrap;
                /* Ngăn việc xuống dòng */
              }
            </style>
  
            <!-- Search, Cart, and Account (2 phần) -->
            <div class="col-3 d-flex justify-content-end align-items-center">
              <!-- Search Form -->
              <!-- Cart Icon -->
              <div id="giohang" class="me-3">
                <a href="/hiengiohang" class="text-white position-relative">
                  <i class="fas fa-cart-plus itemgiohang"></i>
                  <span class="badge bg-danger position-absolute top-0 start-100 translate-middle sogiohang"
                    id="cart-count">
                    {{ session('cart') ? count(session('cart')) : 0 }}
                  </span>
                </a>
              </div>
  
              <!-- Account Section -->
              <div class="dropdown">
                @if (auth()->check())
            <a href="{{ url('/user/' . Auth::user()->id) }}" class="text-white text-decoration-none me-2">
            {{ Auth::user()->name }}
            </a>
            <a href="{{ url('/thoat') }}" class="text-decoration-none text-white">Thoát</a>
          @else
          <a href="#" class="text-white text-decoration-none dropdown-toggle taikhoan" data-bs-toggle="dropdown"
          aria-expanded="false">Tài khoản        </a>
          <ul style="right: -75%" class="dropdown-menu dropdown-menu-end">
          <li><a style="font-size: 16px" class="dropdown-item" href="{{ url('/admin/dangnhap') }}">Đăng nhập</a>
          </li>
          <li><a style="font-size: 16px" class="dropdown-item" href="{{ url('/dangky') }}">Đăng ký</a></li>
          </ul>
        @endif
              </div>
            </div>
          </div>
        </div>
  
        <!-- Success Notification -->
        @if(session()->has('thongbaothem'))
        <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 m-3 p-2" role="alert"
        style="width: 300px;">
        {!! session('thongbaothem') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      </nav>
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
      <div class="text-center mt-5">
        <div class="btn btn-danger fs-3">
          <a style="color: black" href="{{url('/admin/dangnhap')}}">Bạn chưa đăng nhập admin để vào trang admin</a>
        </div>
        <div class="fs-4 mb-5">
          <a href="{{url('/admin/dangnhap')}}">Đăng nhập</a>
          <label style="margin-left: 160px">Chưa có tài khoản -><a href="{{url('/dangky')}}">Đăng ký</a></label>
        </div>
      </div>
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
    <footer>
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
            © 2018. Công ty cổ phần Thế Giới Di Động.
            <span>Xem chính sách sử dụng</span>
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

@endif





