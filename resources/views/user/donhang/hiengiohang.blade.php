@extends('layout')
@section('title') Giỏ hàng @endsection
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
@if(session()->has('thongbaoxoa'))
    <div class="alert alert-success p-3 mx-auto my-3 col-10 fs-5  text-center">
        {!! session('thongbaoxoa') !!}
    </div>
@endif
<table class="table table-giohang table-bordered align-middle border-primary m-2 mb-5" id="tblgiohang">
  <form action="{{route('donhang.thongtinkhachhang')}}" method="POST"> @csrf
    <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
    <caption class="fw-bolder text-center fs-4 mb-3" align="top">
      SẢN PHẨM BẠN ĐÃ CHỌN 
    </caption>
    <tr>
          <thead class="thanhth text-center">
            <th>Tên sản phẩm</th> 
            <th class="giohangimg">Ảnh</th> 
            <th>Số lượng </th>
            <th class="giohangdongia">Đơn giá</th> 
            <th class="giohangthanhtien">Thành tiền</th> 
            <th class="giohangxoa">Xóa</th>
          </thead>
    </tr>   
    @if (session()->has('cart') && count(session('cart')) > 0)
        @foreach ($cart as $c)

            <tr class="thanhtd" id="product-row-{{$c['id_sp']}}">
                <td class="text-center"><b>{{$c['ten_sp']}}</b></td>
                <td class="text-center cartimg"><img src="{{$c['hinh']}}" alt="" width="200px"></td>
                <td>
                    <input name="id_sp{{$c['id_sp']}}" type='number' value="{{$c['soluong']}}" min="1" max="10" class='giohangsoluong form-control m-auto w-50 border-border-secondary shadow-none text-center' onchange="updateTotals()">
                </td>
                <td class="text-center">{{number_format($c['gia'], 0, ',', '.') }} VNĐ</td>
                <td class="text-center">{{number_format($c['thanhtien'], 0, ',', '.') }} VNĐ</td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger" onclick="deleteItem({{$c['id_sp']}})">Xóa</button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="6" class="text-center">Giỏ hàng của bạn hiện đang trống</td>
        </tr>
    @endif


   
    <tfoot>
      @if ($cart && count($cart) > 0)
          <tr>
              <th colspan="4" class="soluongtien text-center">
                  Số lượng sản phẩm: {{$tongsoluong}} . Tổng tiền: {{number_format($tongtien, 0, ',', '.') }} VNĐ
              </th>
              <th colspan="3" class="text-center">
                  <button type="submit" class="btn btn-outline-warning" style="width: 100%; border: 2px solid rgb(144, 157, 252);" id="btnThanhToan">Thanh toán</button>
              </th>
          </tr>
      @endif
  </tfoot>
</table>
<script>
    
    function deleteItem(id) {
    Swal.fire({ 
        title: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
        text: "Sản phẩm sẽ bị xóa khỏi giỏ hàng!",
        icon: 'warning',
        showCancelButton: true, // Hiển thị nút Cancel
        confirmButtonColor: '#d33', // Màu sắc nút "OK"
        cancelButtonColor: '#3085d6', // Màu sắc nút "Cancel"
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Nếu người dùng xác nhận xóa, tiến hành xóa sản phẩm
            fetch(`/xoasptronggio/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json' 
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Xóa sản phẩm thành công!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    // Sau khi thông báo kết thúc, reload trang
                    location.reload();
                });

                const cartCountElement = document.querySelector('#cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.cartCount; 
                }

                const cartTotalElement = document.querySelector('.cart-total');
                if (cartTotalElement) {
                    cartTotalElement.textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.cartTotal) + ' VNĐ';
                }

                const row = document.querySelector(`#product-row-${id}`);
                if (row) {
                    row.remove(); 
                }

                updateTotals();

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



  function updateTotals() {
      let totalAmount = 0; // Tổng tiền
      let totalQuantity = 0; // Tổng số lượng
  
      // Lặp qua tất cả các sản phẩm trong giỏ hàng
      document.querySelectorAll('input[type="number"]').forEach(function(input) {
          const quantity = parseInt(input.value) || 0; // Số lượng
          const row = input.closest('tr'); // Lấy dòng chứa input
          const priceCell = row.querySelector('td:nth-child(4)'); // Ô đơn giá
          const price = parseFloat(priceCell.textContent.replace(/ VNĐ/g, '').replace(/\./g, '')); // Lấy giá và chuyển đổi thành số
  
          const subtotal = quantity * price; // Tính thành tiền cho sản phẩm
          totalAmount += subtotal; // Cộng vào tổng tiền
          totalQuantity += quantity; // Cộng vào tổng số lượng
  
          // Cập nhật thành tiền cho từng sản phẩm
          const subtotalCell = row.querySelector('td:nth-child(5)');
          subtotalCell.textContent = new Intl.NumberFormat('vi-VN').format(subtotal) + ' VNĐ';
          
        // Gửi yêu cầu cập nhật số lượng lên server
        const productId = input.name.replace('id_sp', '');
        
          fetch(`{{ route('update.cart') }}`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({ id: productId, quantity: quantity })
              
          })
          .then(response => response.json())
          .then(data => {
              console.log(data.message); // Xử lý phản hồi từ server nếu cần
          })
          .catch(error => console.error('Error:', error));
      });
  
      // Cập nhật tổng số lượng và tổng tiền
      document.querySelector('th[colspan="4"]').textContent = `Số lượng sản phẩm: ${totalQuantity} . Tổng tiền: ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalAmount)} VNĐ`;
  }
  </script>
  
  
</form>
@endsection


