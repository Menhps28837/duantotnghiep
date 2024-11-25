<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tonkho = ['50', '100', '150','200','250','300','350','400'];

        // Lấy tất cả id sản phẩm từ bảng san_pham
        $productIds = DB::table('san_pham')->pluck('id')->toArray();

        // Kiểm tra nếu số lượng sản phẩm ít hơn 5000
        if (count($productIds) < 5000) {
            throw new \Exception('Không đủ sản phẩm trong bảng san_pham để tạo 5000 bản ghi.');
        }

        for ($i = 0; $i < 5000; $i++) {
            DB::table('so_luong_ton_kho')->insert([
                'id_sp' => $productIds[$i], // Lấy id sản phẩm
                'so_luong_con_lai' => $tonkho[array_rand($tonkho)], // Lấy ngẫu nhiên số lượng còn lại
                'so_luong_canh_bao' => 10, // Ví dụ, có thể thay đổi nếu cần
            ]);
        }
    }
}
