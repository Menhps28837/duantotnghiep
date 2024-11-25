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
        Schema::table('thuoc_tinh', function (Blueprint $table) {
            $table->string('bao_hanh')->nullable(); // Thêm cột bảo hành
        });
    }
    
    public function down()
    {
        Schema::table('thuoc_tinh', function (Blueprint $table) {
            $table->dropColumn('bao_hanh'); // Xóa cột bảo hành
        });
    }
};
