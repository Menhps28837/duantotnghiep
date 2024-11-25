<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('yeu_cau_tra_hang', function (Blueprint $table) {
            $table->text('reasons')->nullable(); // Thêm cột reasons
        });
    }

    public function down()
    {
        Schema::table('yeu_cau_tra_hang', function (Blueprint $table) {
            $table->dropColumn('reasons'); // Xóa cột reasons khi rollback
        });
    }
};

