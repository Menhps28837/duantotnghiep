<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('don_hang', function (Blueprint $table) {
            $table->boolean('da_thanh_toan')->default(false); // false: chưa thanh toán, true: đã thanh toán
        });
    }
    
    public function down() {
        Schema::table('don_hang', function (Blueprint $table) {
            $table->dropColumn('da_thanh_toan');
        });
    }
    
};
