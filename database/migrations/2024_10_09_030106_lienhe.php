<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lien_he', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten'); // Họ tên
            $table->string('email'); // Email
            $table->text('noi_dung'); // Nội dung liên hệ
            $table->timestamp('thoi_gian')->default(now()); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('lien_he');
    }
};
