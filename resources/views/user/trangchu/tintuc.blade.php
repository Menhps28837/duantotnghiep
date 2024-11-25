{{-- <section>
<h2 style="background-color: #000000;" class=" p-3 mt-2 fs-5 text-white"> TIN TỨC</h2>
    <div id="data" class="d-flex flex-wrap">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-light">
                <img src="/images/banner10.jpg" class="card-img-top img-fluid" alt="Banner 1" style="height: 200px; object-fit: cover;"> <!-- Thiết lập chiều cao cố định và giữ tỷ lệ cho ảnh -->
                <div class="card-body text-center"> 
                    <h5 class="card-title">Những sản phẩm Apple màu vàng? Bạn thích màu nào nhất?</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-light">
                <img src="/images/banner11.jpg" class="card-img-top img-fluid" alt="Banner 2" style="height: 200px; object-fit: cover;"> <!-- Thiết lập chiều cao cố định và giữ tỷ lệ cho ảnh -->
                <div class="card-body text-center">
                    <h5 class="card-title">Những lý do tin rằng iPhone 15 có thời lượng pin tốt hơn?</h5> 
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-light">
                <img src="/images/banner12.jpg" class="card-img-top img-fluid" alt="Banner 3" style="height: 200px; object-fit: cover;"> <!-- Thiết lập chiều cao cố định và giữ tỷ lệ cho ảnh -->
                <div class="card-body text-center">
                    <h5 class="card-title">Apple ra iPhone 14 & iPhone 14 Plus màu vàng, bán ra ngày 14 tháng 3</h5> 
                </div>
            </div>
        </div>
    </div>
    </div> --}}


    <h2 style="background-color: #000000;" class="p-3 mt-2 fs-5 text-white">TIN TỨC NỔI BẬT</h2>
        <div class="row d-flex mt-3">
            @foreach($tinTucs as $tinTuc)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column"> 
                        <img style="height: 150px" src="{{ asset('storage/tin_tuc/' . $tinTuc->anh) }}" class="card-img-top" alt="{{ $tinTuc->tieu_de }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ Str::limit($tinTuc->tieu_de, 50) }}</h5>
                            <p class="card-text">{{ Str::limit($tinTuc->noi_dung, 50) }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <p class="text-muted mb-0">Ngày đăng: {{date('d/m/Y',strtotime($tinTuc->ngay_dang))}}</p>
                            <a href="{{ route('tin_tucs.show', $tinTuc->id) }}" class="btn btn-primary">Xem Chi Tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    