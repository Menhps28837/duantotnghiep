<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tin_tuc', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de'); // Tiêu đề
            $table->text('noi_dung'); // Nội dung tin tức
            $table->string('anh'); // Đường dẫn đến ảnh
            $table->timestamp('ngay_dang')->useCurrent(); // Ngày đăng
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tin_tuc');
    }
};
