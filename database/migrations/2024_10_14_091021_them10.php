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
        Schema::create('yeu_cau_tra_hang', function (Blueprint $table) {
            $table->id(); // Tạo cột ID
            $table->foreignId('id_dh')->constrained('don_hang')->onDelete('cascade'); // Khóa ngoại đến bảng đơn hàng
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Khóa ngoại đến bảng người dùng
            $table->text('lydo'); // Lý do trả hàng
            $table->integer('status')->default(0); ; // Trạng thái (pending, approved, rejected)
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('yeu_cau_tra_hang');
    }
};
