<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('khuyen_mai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_sp'); // Khóa ngoại liên kết đến bảng sản phẩm
            $table->decimal('gia_km', 10, 2); // Giá khuyến mãi
            $table->date('ngay_bat_dau'); // Ngày bắt đầu
            $table->date('ngay_ket_thuc'); // Ngày kết thúc
            $table->timestamps();
    
            // Thiết lập khóa ngoại
            $table->foreign('id_sp')->references('id')->on('san_pham')->onDelete('cascade');
        });
    }
    
};
