<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('loai', function (Blueprint $table) {
            $table->id();
            $table->string('ten_loai',100);
            $table->string('slug',100)->nullable();
            $table->integer('thu_tu')->default(0);
            $table->boolean('an_hien')->default(0);
            $table->timestamps();
        });
        Schema::create('san_pham', function (Blueprint $table) {
            $table->id();
            $table->string('ten_sp',200);
            $table->string('slug',200)->nullable();
            $table->integer('gia');
            $table->integer('gia_km')->nullable();
            $table->unsignedBigInteger('id_loai')->index();
            $table->date('ngay');
            $table->string('hinh',255)->nullable();
            $table->boolean('hot')->default(0);
            $table->integer('luot_xem')->default(0);
            $table->boolean('an_hien')->default(0);
            $table->boolean('tinh_chat'); // 0 bình thường, 1 giá rẻ, 2 giảm sốc, 3 cao cấp
            $table->text('mo_ta')->nullable();
            $table->timestamps();
            $table->foreign('id_loai')->references('id')->on('loai');

        });
        Schema::create('thuoc_tinh', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sp')->unique();
            $table->string('he_dieu_hanh', 50)->nullable(); // Hệ điều hành
            $table->string('cpu', 50)->nullable();
            $table->string('ram', 50)->nullable();
            $table->string('bo_nho', 50)->nullable(); // Thay 'dia_cung' thành 'bo_nho_trong'
            $table->string('mau_sac', 50)->nullable();
            $table->string('can_nang', 50)->nullable();
            $table->string('do_phan_giai_man_hinh', 50)->nullable(); // Độ phân giải màn hình
            $table->string('tan_so_quet', 50)->nullable();
            $table->string('camera_chinh', 50)->nullable(); // Độ phân giải camera chính
            $table->string('camera_phu', 50)->nullable(); // Độ phân giải camera phụ (nếu có)
            $table->string('pin', 50)->nullable(); // Dung lượng pin
            $table->string('cong_ket_noi', 50)->nullable(); 
            $table->string('ket_noi_mang', 50)->nullable(); // Ví dụ: 4G, 5G
            $table->timestamps();
            $table->foreign('id_sp')->references('id')->on('san_pham');
        });
        Schema::create('don_hang', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->index()->comment('');
            $table->datetime('thoi_diem_mua_hang')->comment('Thời điểm mua hàng');
            $table->string('ten_nguoi_nhan')->comment('Họ tên người nhận');
            // $table->string('email')->comment('Email người nhận');
            $table->string('dien_thoai',100)->comment('Điện thoại người nhận hàng');
            $table->string('dia_chi_giao',100)->comment('Địa chỉ giao hàng');
            $table->boolean('trang_thai')->default(0)->comment('Trạng thái đơn hàng');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users');

        });
        Schema::create('binh_luan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sp')->index()->comment('Mã sản phẩm');
            $table->unsignedBigInteger('id_user')->index()->comment('Người bình luận');
            $table->text('noi_dung')->comment('Nội dung bình luận');
            $table->datetime('thoi_diem')->comment('Thời điểm bình luận');
            $table->boolean('an_hien')->default(0)->comment('0 là ẩn 1 là hiện');             
            $table->timestamps();
            $table->foreign('id_sp')->references('id')->on('san_pham');
            $table->foreign('id_user')->references('id')->on('users');
        });
        Schema::create('doi_tac', function (Blueprint $table) {
            $table->id();
            $table->string('hinh')->nullable();
            $table->integer('thu_tu')->default(0);
            $table->boolean('an_hien')->default(0);             
            $table->timestamps();
        });
        // Schema::create('orders', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email');
        //     $table->string('dien_thoai');
        //     $table->text('dia_chi');
        //     $table->decimal('total_price', 10, 2);
        //     $table->integer('total_quantity');
        //     $table->string('payment_method');
        //     $table->string('payment_status');
        //     $table->string('shipping_method');
        //     $table->string('shipping_status');
        //     $table->timestamps();
        // });
                
    }

    public function down(): void
    {
        Schema::dropIfExists('loai');
        Schema::dropIfExists('san_pham');
        Schema::dropIfExists('thuoc_tinh');
        Schema::dropIfExists('don_hang');
        // Schema::dropIfExists('don_hang_chi_tiet');
        Schema::dropIfExists('binh_luan');
        Schema::dropIfExists('doi_tac');
        Schema::dropIfExists('orders');

    }
};
