<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('don_hang_chi_tiet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dh')->index()->comment('Mã đơn hàng');
            $table->unsignedBigInteger('id_sp')->index()->comment('Mã sản phẩm');
            $table->string('ten_sp')->nullable();
            $table->string('hinh')->nullable();
            $table->integer('so_luong')->default(1)->comment('Số lượng mua');   
            $table->integer('gia')->comment('Giá mua sản phẩm');  
            $table->string('thanh_tien')->comment('Thành tiền');
            $table->timestamps();
            $table->foreign('id_dh')->references('id')->on('don_hang');
            $table->foreign('id_sp')->references('id')->on('san_pham');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_hang_chi_tiet');
    }
};
