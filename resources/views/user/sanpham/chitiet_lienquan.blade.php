<div id="splienquan">
    <h2 class="bg-dark p-2 fs-5 text-white"> Sản phẩm liên quan</h2>
    <div id="data" class="d-flex flex-wrap">
        @foreach($splienquan_arr as $sp)
                <div class="col-md-3 col-6 p-2">
                    <a href="/sp/{{$sp->id}}" class="text-decoration-none text-dark fs-5">
                        <div class="product-card border border-secondary shadow-sm rounded text-center bg-white d-flex flex-column"
                            style="width: 100%; height: 100%;">
                            <img src="{{$sp->hinh}}" class="border-0" style="height:200px; width: 100%; object-fit: cover;">
                            <h5 class="mt-3">{{$sp->ten_sp}}</h5>
                            <div class="product-content flex-grow-1 d-flex flex-column justify-content-between">
                                <div class='fw-bold text-danger fs-5 mt-1 mb-2'>
                                    {{ number_format($sp->gia_km, 0, ",", ".") }} đ
                                    <!-- <span style="font-size: 14px; color: gray; padding-left: 10px">{{ $sp->luot_xem }} lượt
                                        xem</span> -->
                                </div>
                            </div>
                    </a>
                    <button type="button" class="col-9 col-6 m-auto btn btn-add-to-cart mb-3"
                        onclick="addToCart({{ $sp->id }}, 1)">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                </div>
            </div>
        @endforeach
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