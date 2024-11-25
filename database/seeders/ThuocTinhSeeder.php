<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThuocTinhSeeder extends Seeder
{
        // $ram_arr = ['4GB', '8GB', '16GB', '32GB'];

        // for ($i = 0; $i < 5000; $i++) {
        //     $ram = $ram_arr[array_rand($ram_arr)];
        //     $bao_hanh = ($ram == '16GB' || $ram == '32GB') ? '3 năm' : '2 năm';

        //     DB::table('thuoc_tinh')->insert([
        //         'id_sp' => rand(1, 1000), // Thay đổi theo ID sản phẩm thực tế
        //         'ram' => $ram,
        //         'cpu' => 'CPU mẫu', // Thay thế với giá trị thực tế
        //         'dia_cung' => 'Ổ cứng mẫu', // Thay thế với giá trị thực tế
        //         'mau_sac' => 'Màu sắc mẫu', // Thay thế với giá trị thực tế
        //         'can_nang' => rand(1, 5), // Thay thế với giá trị thực tế
        //         'bao_hanh' => $bao_hanh,
        //     ]);
        // }
        public function run()
        {
            $thuoc_tinh_records = DB::table('thuoc_tinh')->get();
    
            foreach ($thuoc_tinh_records as $record) {
                $bao_hanh = ($record->ram == '16GB' || $record->ram == '32GB') ? '3 năm' : '2 năm';
    
                DB::table('thuoc_tinh')->where('id', $record->id)->update([
                    'bao_hanh' => $bao_hanh,
                ]);
            }
        }
    
}

