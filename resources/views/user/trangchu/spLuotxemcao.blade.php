<section>
    <h2 style="background-color: #000000;" class="p-3 mt-2 fs-5 text-white">SẢN PHẨM LƯỢT XEM CAO</h2>
    <div id="data" class="d-flex flex-wrap" style="margin: -5px;"> <!-- Khoảng cách âm xung quanh container -->
        @foreach($spluotxemcao_arr as $sp)
            <div class="col-6 col-md-3 p-2">
                <a href="/sp/{{$sp->id}}" class="text-decoration-none text-dark fs-5">
                    <div class="product-card border border-secondary shadow-sm rounded text-center bg-white d-flex flex-column h-100">
                        <img src="{{$sp->hinh}}" class="product-img img-fluid border-0">
                        <div class="product-content flex-grow-1 d-flex flex-column justify-content-between px-2">
                            <h5 class="mt-2 product-title">{{$sp->ten_sp}}</h5>
                            <div class='fw-bold text-danger fs-6 mb-2'>
                                {{ number_format($sp->gia_km, 0, ",", ".") }} đ
                                <span class="product-views text-muted small d-block">{{ $sp->luot_xem }} lượt xem</span>
                            </div>
                        </div>
                </a>
                        <button type="button" class="btn btn-sm btn-primary mb-2 mx-auto btn-add-to-cart"
                            onclick="addToCart({{ $sp->id }}, 1)">
                            <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                        </button>
                    </div>
            </div>
        @endforeach
    </div>
</section>
