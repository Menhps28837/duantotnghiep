@extends('layout')

@section('title', 'Kết quả tìm kiếm')

@section('noidungchinh')
    <h2 class="text-center mt-3">Kết quả tìm kiếm cho "{{ $search }}"</h2>

    @if($sptrongloai_arr->isEmpty())
        <p class="text-center">Không có sản phẩm nào phù hợp với tìm kiếm của bạn.</p>
        <p class="text-center">Mời bạn tìm kiếm sản phẩm khác.</p>
    @else
        <div class="row">
            @foreach($sptrongloai_arr as $sp)
            <div class="col-6 col-md-3 p-2">
                <a href="/sp/{{$sp->id}}" class="text-decoration-none text-dark fs-5">
                    <div class="product-card border border-secondary shadow-sm rounded text-center bg-white d-flex flex-column"
                        style="width: 100%; height: 100%;">
                        <img src="{{$sp->hinh}}" class="product-img img-fluid border-0">
                        <div class="product-content flex-grow-1 d-flex flex-column justify-content-between">
                            <h5 class="mt-3">{{$sp->ten_sp}}</h5>
    
                            <div class='fw-bold text-danger fs-5 mb-2'>
                                {{ number_format($sp->gia_km, 0, ",", ".") }} đ
                                <span class="lx" style="font-size: 14px; color: gray; padding-left: 10px">{{ $sp->luot_xem }} lượt xem</span>
                            </div>
                    </div>
                </a>
                <button type="button" class="btn btn-sm btn-primary mb-2 mx-auto btn-add-to-cart" onclick="addToCart({{ $sp->id }}, 1)">
                    <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                </button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-2 d-flex justify-content-center">{{$sptrongloai_arr->links() }}</div>
    @endif
    <style>
        /* .col-md-3 {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        } */
        h3.fs-5 {
            min-height: 50px;
        }
    
        /* Hình ảnh sản phẩm */
        .product-img {
            /* height: 200px; */
            object-fit: cover;
        }
    
        @media (max-width: 768px) {
    
            /* Hình ảnh nhỏ hơn trên mobile */
            .product-img {
                height: 200px;
            }
    
            /* Font chữ nhỏ hơn */
            .product-title {
                font-size: 0.9rem;
            }
    
            /* Khoảng cách giữa nội dung và hình ảnh */
            .product-content {
                padding: 5px;
            }
    
            /* Nút thêm vào giỏ hàng nhỏ hơn */
            .btn-add-to-cart {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
        }
    
        @media (max-width: 576px) {
    
            /* Chiều cao ảnh giảm thêm trên màn hình nhỏ */
            .product-img {
                height: auto;
            }
            .lx{
                display: flex;
                margin-left: 30px;
            }
        }
    </style>
@endsection
