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
        Schema::create('so_luong_ton_kho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_sp')->constrained('san_pham'); // Foreign key referencing the products table
            $table->integer('so_luong_con_lai')->default(0); // Stock quantity
            $table->integer('so_luong_canh_bao')->default(10); // Alert threshold
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('so_luong_ton_kho');
    }
};
