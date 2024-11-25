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
        Schema::table('khuyen_mai', function (Blueprint $table) {
            $table->decimal('giam_gia', 5, 2); // Thay đổi kiểu dữ liệu nếu cần
        });
    }

    public function down(): void
    {
        Schema::table('khuyen_mai', function (Blueprint $table) {
            $table->dropColumn('giam_gia'); // Xóa cột bảo hành
        });
    }
};
