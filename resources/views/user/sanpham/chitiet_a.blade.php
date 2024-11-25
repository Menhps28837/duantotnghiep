@if(session()->has('thongbao'))
  <div class="alert alert-danger p-3 mx-auto my-3 col-10 fs-5 text-center">
    {!! session('thongbao') !!}
  </div>
@endif
<h1 class="p-2 fs-5"><a style="color: black" href="/">Trang chủ</a> > {{$sp->ten_sp}}</h1>

<div id='chitietsp' class="d-flex flex-column flex-md-row">
  <!-- Image Section -->
  <div class="col-12 col-md-6 mt-3 mb-3">
    <img src="{{$sp->hinh}}" class="w-100 m-auto" alt="{{ $sp->ten_sp }}" title="Hình sản phẩm {{ $sp->ten_sp }}">
  </div>
  <!-- Product Details Section -->
  <div class="col-12 col-md-6 p-2 fs-5">
    <h1 class="h3 mt-0 mb-2 mt-2"> {{ $sp->ten_sp }} </h1>

    <div class="mb-3">
      <span>Giá cũ</span>: <del>{{ number_format($sp->gia, 0, ',', '.') }} VNĐ</del> <br>
      <span>Giá hiện tại</span>: {{ number_format($sp->gia_km, 0, ',', '.') }} VNĐ
    </div>

    @if ($tonkho)
    <div class="mb-3">
      <span>Số lượng còn lại</span>: {{ $tonkho->so_luong_con_lai }} sản phẩm
    </div>
    @else
    <div class="mb-3">
      <span>Số lượng còn lại</span>: Không có thông tin
    </div>
    @endif

    <div class="mb-3">
      <span>Ngày cập nhật</span>: {{ date('d/m/Y', strtotime($sp->ngay)) }}
    </div>

    <!-- Tổng số lượt đánh giá -->
    @if($reviewCount > 0)
    <div class="mb-3">
      <span>Tổng số lượt đánh giá</span>: {{ $reviewCount }} lượt
      <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#reviewModal">
        Xem đánh giá
      </button>
    </div>
  @endif

    <div>
      <button type="button" class="col-8 col-md-4 m-auto btn btn-add-to-cart mb-3"
        onclick="addToCart({{ $sp->id }}, 1)">
        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
      </button>
    </div>
  </div>
</div>

<!-- Modal Xem Đánh Giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach ($danh_gia_arr as $review)
          <div class="mb-3">
            <!-- Kiểm tra xem người dùng có tồn tại hay không -->
            @if ($review->user)
              <p><strong>{{ $review->user->name }}</strong> 
              @if ($review->rating == 0)
                (Tốt)
              @elseif ($review->rating == 1)
                (Trung bình)
              @elseif ($review->rating == 2)
                (Không tốt)
              @endif
              </p>
            @else
              <p><strong>Người dùng không xác định</strong></p>
            @endif
            <div class="row">
              <div class="col-6">
                <p>{{ $review->comment }}</p>
              </div>
              <div class="col-6 text-end">
                <p><small>Thời gian: {{date('d/m/Y',strtotime($review->created_at))}}</small></p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>



<script>
  // Hàm gọi khi thêm sản phẩm vào giỏ hàng
  function addToCart(id_sp, soluong) {
    fetch(`/themvaogio/${id_sp}/${soluong}`, {
      method: 'GET',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
      .then(response => response.json())
      .then(data => {
        alert(data.message); // Hiển thị thông báo thành công

        // Cập nhật số lượng trong giỏ hàng
        let cartCountElement = document.getElementById('cart-count');
        let currentCount = parseInt(cartCountElement.textContent) || 0;

        // Cập nhật số lượng
        cartCountElement.textContent = currentCount + soluong; // Cập nhật theo số lượng đã thêm
      })
      .catch(error => console.error('Error:', error));
  }
</script>
<div class="prod-tabs-wrap p-3">
  <ul class="nav nav-tabs prod-tabs">
    <li class="nav-item">
      <a class="nav-link doimau active bg-dark text-white w-100" data-prodtab-num="1" href="#"
        data-prodtab="#prod-tab-1">Mô
        tả</a>
    </li>
    <li class="nav-item">
      <a class="nav-link doimau w-100" data-prodtab-num="2" href="#" data-prodtab="#prod-tab-2">Thông số kĩ thuật</a>
    </li>
  </ul>
  <style>
    .nav-link.doimau {
      background-color: white;
      color: black;
    }

    .nav-link.doimau.active {
      background-color: black;
      color: white;
    }

    .nav-link.doimau:hover {
      background-color: black;
      color: white;
    }

    .nav-link.doimau {
      transition: background-color 0.3s ease, color 0.3s ease;
    }
  </style>


  <div class="tab-content prod-tab-cont">
    <!-- Description Tab -->
    <div class="tab-pane fade show active fs-5" id="prod-tab-1">
      <div id="short-content">
        <p><a href="/sp/{{$sp->id}}">{{ $sp->ten_sp }}</a> một thành viên mới nhất trong dòng sản phẩm <a
            href="/loai/{{$lt->id}}">{{$lt->ten_loai}}</a>, hứa hẹn mang đến nhiều tính năng tiên tiến cùng với kết nối
          5G tốc độ cao. Sản phẩm được trình làng với mục tiêu cung cấp một chiếc điện thoại thông minh cao cấp, đa chức
          năng nhưng với mức giá phải chăng.</p>
      </div>
      <div id="full-content" style="display: none;">
        <p>Với khung viền kim loại cứng cáp, {{ $sp->ten_sp }} không chỉ đẹp mắt mà còn rất bền bỉ. Sự kết hợp giữa vẻ
          ngoài sang trọng và độ bền tạo nên một cảm giác chắc chắn và đáng tin cậy. Điều này giúp bảo vệ thiết bị trước
          các tác động xung quanh và gia tăng tuổi thọ của máy.</p>

        <p>Mặt trước của {{ $sp->ten_sp }} được bảo vệ bởi kính cường lực Corning Gorilla Glass 7+, mang lại độ bền và
          khả năng chống va đập tốt trong thị trường điện thoại di động hiện nay. Mặt sau của thiết bị là nơi đặt cụm
          camera quen thuộc với 3 ống kính bố trí rời, giúp tạo nên vẻ đặc trưng của dòng điện thoại này.</p>
      </div>
      <button id="toggle-button" class="btn btn-dark mb-3" onclick="fullnoidung()">Xem thêm</button>
    </div>
    <script>
      function fullnoidung() {
        const shortContent = document.getElementById('short-content');
        const fullContent = document.getElementById('full-content');
        const button = document.getElementById('toggle-button');

        if (fullContent.style.display === 'none') {
          fullContent.style.display = 'block';
          button.textContent = 'Ẩn bớt';
        } else {
          fullContent.style.display = 'none';
          button.textContent = 'Xem thêm';
        }
      }
    </script>
    <!-- Features Tab -->
    <div class="tab-pane fade" id="prod-tab-2">
      @if ($thuoc_tinh)
      <table class="table">
      <tbody>
        <tr>
        <td>Hệ điều hành</td>
        <td>{{ $thuoc_tinh->he_dieu_hanh }}</td>
        </tr>
        <tr>
        <td>RAM</td>
        <td>{{ $thuoc_tinh->ram }}</td>
        </tr>
        <tr>
        <td>CPU</td>
        <td>{{ $thuoc_tinh->cpu }}</td>
        </tr>
        <tr>
        <td>Camera chính</td>
        <td>{{ $thuoc_tinh->camera_chinh }}</td>
        </tr>
        <tr>
        <td>Camera phụ</td>
        <td>{{ $thuoc_tinh->camera_phu }}</td>
        </tr>
        <tr>
        <td>Độ phân giải</td>
        <td>{{ $thuoc_tinh->do_phan_giai_man_hinh }}</td>
        </tr>
        <tr>
        <td>Tần số quét</td>
        <td>{{ $thuoc_tinh->tan_so_quet }}</td>
        </tr>
        <tr>
        <td>Bộ nhớ</td>
        <td>{{ $thuoc_tinh->bo_nho }}</td>
        </tr>
        <tr>
        <td>Pin</td>
        <td>{{ $thuoc_tinh->pin }}</td>
        </tr>
        <tr>
        <td>Màu sắc</td>
        <td>Màu {{ $thuoc_tinh->mau_sac }}</td>
        </tr>
        <tr>
        <td>Cân nặng</td>
        <td>{{ $thuoc_tinh->can_nang }} kg</td>
        </tr>
        <tr>
        <td>Lượt xem</td>
        <td>{{ $sp->luot_xem }} lượt xem</td>
        </tr>
      </tbody>
      </table>
    @endif
    </div>
  </div>
</div>
<!-- JavaScript to Handle Add to Cart -->
<script>
  function addToCart(id_sp, soluong) {
    fetch(`/themvaogio/${id_sp}/${soluong}`, {
      method: 'GET',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      }
    })
      .then(response => response.json())
      .then(data => {
        alert(data.message); // Display success message

        // Update cart count
        let cartCountElement = document.getElementById('cart-count');
        let currentCount = parseInt(cartCountElement.textContent) || 0;

        cartCountElement.textContent = currentCount + soluong;
      })
      .catch(error => console.error('Error:', error));
  }
  //code chuyen tab thong tin
  document.querySelectorAll('.prod-tabs a').forEach(tab => {
    tab.addEventListener('click', function (e) {
      e.preventDefault();
      // Xóa lớp 'active' khỏi tất cả các tab
      document.querySelectorAll('.prod-tabs .nav-link').forEach(link => {
        link.classList.remove('active');
      });

      // Thêm lớp 'active' vào tab đang được nhấp
      this.classList.add('active');

      // Ẩn tất cả các tab nội dung
      document.querySelectorAll('.tab-pane').forEach(tabPane => {
        tabPane.classList.remove('show', 'active');
      });

      // Hiển thị tab nội dung tương ứng
      const targetTab = document.querySelector(this.getAttribute('data-prodtab'));
      if (targetTab) {
        targetTab.classList.add('show', 'active');
      }
    });
  });
  // quan ly mau nen khi chuyen tab
  const tabs = document.querySelectorAll('.nav-link');

  tabs.forEach(tab => {
    tab.addEventListener('click', function () {
      // Xóa lớp bg-dark và text-white từ tất cả các tab
      tabs.forEach(t => {
        t.classList.remove('bg-dark', 'text-white');
      });
      // Thêm lớp bg-dark và text-white vào tab đang được chọn
      this.classList.add('bg-dark', 'text-white');
    });
  });
</script>