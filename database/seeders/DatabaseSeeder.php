<?php
namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr; //array helper
use Illuminate\Support\Str; //string helper

class DatabaseSeeder extends Seeder {
    public function run(): void  {
        //chèn bảng users
        DB::table('users')->insert([
            [ 'name' => 'Đỗ Đạt Cao', 'password' => bcrypt('hehe') , 'dia_chi'=>'',
                'email' => 'dodatcao@gmail.com','dien_thoai' => '0918765238',
                'hinh' => '','role' => 1 ], 
            [ 'name' => 'Mai Anh Tới', 'password' => bcrypt('hehe') ,'dia_chi'=>'',
                'email' => 'maianhtoi@gmail.com','dien_thoai' => '098532482',
                'hinh' => '','role' => 0 ],
            [ 'name' => 'Đào Kho Báu', 'password' => bcrypt('hehe') ,'dia_chi'=>'',
                'email' => 'daokhobau@gmail.com','dien_thoai' => '097397392',
                'hinh' => '','role' => 1]
        ]);
        //chèn bảng loai
        $loai_arr = ['Apple', 'Samsung', 'Xiaomi', 'Oppo', 'Vivo', 'Huawei'];
        for ($i=0; $i<count($loai_arr); $i++){
            DB::table('loai')->insert(
                ['ten_loai' => $loai_arr[$i], 'thu_tu' => $i ,'an_hien' => 1]
            );
        };
        //chèn bảng sản phẩm và thuộc tính
        $apple_arr = [
            'iPhone 15 Pro Max', 'iPhone 15 Pro', 'iPhone 14 Pro Max', 'iPhone 14 Pro', 'iPhone 13 Pro Max',
            'iPhone 13 Pro', 'iPhone SE (2022)', 'iPhone 12', 'iPhone 12 Mini', 'iPhone 11 Pro Max',
            'iPhone 11 Pro', 'iPhone 11', 'iPhone XS Max', 'iPhone XS', 'iPhone XR',
            'iPhone X', 'iPhone 8 Plus', 'iPhone 8', 'iPhone 7 Plus', 'iPhone 7',
            'iPhone 6S Plus', 'iPhone 6S', 'iPhone SE (2016)', 'iPad Pro 12.9', 'iPad Pro 11',
            'iPad Air', 'iPad Mini', 'MacBook Pro 16', 'MacBook Pro 14', 'MacBook Air 13',
            'Apple Watch Ultra', 'Apple Watch Series 8', 'Apple Watch SE', 'AirPods Pro 2', 'AirPods 3',
            'AirPods Max', 'Apple TV 4K', 'iMac 24', 'iMac 21.5', 'Mac Mini'
        ];
        
        $samsung_arr = [
            'Samsung Galaxy S23 Ultra', 'Samsung Galaxy S23+', 'Samsung Galaxy S23', 'Samsung Galaxy Z Fold 5',
            'Samsung Galaxy Z Flip 5', 'Samsung Galaxy A54', 'Samsung Galaxy A34', 'Samsung Galaxy A14',
            'Samsung Galaxy Note 20 Ultra', 'Samsung Galaxy Note 20', 'Samsung Galaxy S22 Ultra', 'Samsung Galaxy S22+',
            'Samsung Galaxy S22', 'Samsung Galaxy A73', 'Samsung Galaxy A53', 'Samsung Galaxy M53',
            'Samsung Galaxy M33', 'Samsung Galaxy F23', 'Samsung Galaxy Tab S8 Ultra', 'Samsung Galaxy Tab S8+',
            'Samsung Galaxy Tab S8', 'Samsung Galaxy Tab A8', 'Samsung Galaxy Watch 5', 'Samsung Galaxy Watch 4',
            'Samsung Galaxy Watch Active 2', 'Samsung Galaxy Buds 2 Pro', 'Samsung Galaxy Buds Live', 'Samsung Galaxy Z Fold 4',
            'Samsung Galaxy Z Flip 4', 'Samsung Galaxy S21 FE', 'Samsung Galaxy S21 Ultra', 'Samsung Galaxy S21+',
            'Samsung Galaxy S21', 'Samsung Galaxy A52', 'Samsung Galaxy A32', 'Samsung Galaxy A22', 'Samsung Galaxy M12',
            'Samsung Galaxy M02', 'Samsung Galaxy F12', 'Samsung Galaxy F02s'
        ];
        
        $xiaomi_arr = [
            'Xiaomi 13 Pro', 'Xiaomi 13', 'Xiaomi 12 Pro', 'Xiaomi 12', 'Xiaomi Mi 11 Ultra',
            'Xiaomi Mi 11', 'Xiaomi Mi 10 Pro', 'Xiaomi Mi 10', 'Xiaomi Mi 9', 'Xiaomi Mi 8',
            'Xiaomi Redmi Note 12 Pro+', 'Xiaomi Redmi Note 12 Pro', 'Xiaomi Redmi Note 12', 'Xiaomi Redmi Note 11 Pro',
            'Xiaomi Redmi Note 11', 'Xiaomi Redmi Note 10', 'Xiaomi Redmi Note 9 Pro', 'Xiaomi Redmi Note 9',
            'Xiaomi Redmi 10', 'Xiaomi Redmi 9', 'Xiaomi POCO F4', 'Xiaomi POCO F3', 'Xiaomi POCO X4 Pro', 'Xiaomi POCO X3 Pro',
            'Xiaomi POCO X3 NFC', 'Xiaomi Black Shark 5 Pro', 'Xiaomi Black Shark 4 Pro', 'Xiaomi Black Shark 3 Pro',
            'Xiaomi Black Shark 2 Pro', 'Xiaomi Black Shark', 'Xiaomi Mi MIX 4', 'Xiaomi Mi MIX 3', 'Xiaomi Mi MIX 2S',
            'Xiaomi Mi MIX Alpha', 'Xiaomi Mi A3', 'Xiaomi Mi A2', 'Xiaomi Mi A1', 'Xiaomi Mi Pad 5', 'Xiaomi Mi Pad 4',
            'Xiaomi Mi Pad 3'
        ];
        
        $oppo_arr = [
            'OPPO Find X5 Pro', 'OPPO Find X5', 'OPPO Reno 8 Pro', 'OPPO Reno 8', 'OPPO A78 5G',
            'OPPO A57', 'OPPO A54', 'OPPO F21 Pro', 'OPPO F19 Pro', 'OPPO F17 Pro',
            'OPPO Reno 7 Pro', 'OPPO Reno 7', 'OPPO Reno 6 Pro', 'OPPO Reno 6', 'OPPO Reno 5 Pro',
            'OPPO Reno 5', 'OPPO F15', 'OPPO A92', 'OPPO A31', 'OPPO A9 2020',
            'OPPO A5 2020', 'OPPO A3s', 'OPPO A1k', 'OPPO K10', 'OPPO K9 Pro',
            'OPPO K7x', 'OPPO F9', 'OPPO F7', 'OPPO F5', 'OPPO Neo 7',
            'OPPO R17 Pro', 'OPPO R15 Pro', 'OPPO R11s', 'OPPO R9s', 'OPPO A95',
            'OPPO A74', 'OPPO A73', 'OPPO A33', 'OPPO A12', 'OPPO Reno Ace'
        ];
        
        $vivo_arr = [
            'Vivo X90 Pro+', 'Vivo X90 Pro', 'Vivo X80 Pro', 'Vivo X80', 'Vivo V27 Pro',
            'Vivo V25 Pro', 'Vivo V23 Pro', 'Vivo V21 Pro', 'Vivo V20 Pro', 'Vivo V19 Pro',
            'Vivo Y72', 'Vivo Y52', 'Vivo Y20', 'Vivo Y12s', 'Vivo Y1s',
            'Vivo V17 Pro', 'Vivo V15 Pro', 'Vivo V11 Pro', 'Vivo V9 Pro', 'Vivo V7+',
            'Vivo X60 Pro', 'Vivo X50 Pro', 'Vivo X21', 'Vivo X9', 'Vivo Z1 Pro',
            'Vivo Y33s', 'Vivo Y21s', 'Vivo Y11', 'Vivo Y91', 'Vivo Y85',
            'Vivo NEX 3', 'Vivo NEX Dual Display', 'Vivo NEX S', 'Vivo NEX A', 'Vivo X27',
            'Vivo X21i', 'Vivo Xplay 7', 'Vivo Xshot', 'Vivo S1 Pro', 'Vivo S5'
        ];
        
        $huawei_arr = [
            'Huawei P60 Pro', 'Huawei Mate 50 Pro', 'Huawei Nova 10 Pro', 'Huawei P50 Pro', 'Huawei Mate 40 Pro',
            'Huawei P40 Pro', 'Huawei Mate 30 Pro', 'Huawei Nova 9 Pro', 'Huawei P30 Pro', 'Huawei Mate 20 Pro',
            'Huawei P20 Pro', 'Huawei Mate 10 Pro', 'Huawei Nova 8 Pro', 'Huawei P10 Plus', 'Huawei Mate 9 Pro',
            'Huawei Nova 7 Pro', 'Huawei P9 Plus', 'Huawei Mate 8', 'Huawei Honor 20 Pro', 'Huawei Honor 10 Pro',
            'Huawei Mate Xs 2', 'Huawei Mate X2', 'Huawei Mate X', 'Huawei Nova 5 Pro', 'Huawei Nova 4 Pro',
            'Huawei Enjoy 20 Pro', 'Huawei Enjoy 10 Pro', 'Huawei Enjoy 9 Plus', 'Huawei Enjoy 8 Plus', 'Huawei G9 Plus',
            'Huawei Ascend Mate7', 'Huawei Ascend P7', 'Huawei Ascend G7', 'Huawei Ascend Y6', 'Huawei Ascend Y5',
            'Huawei P Smart 2021', 'Huawei Y9 Prime 2019', 'Huawei MediaPad M6', 'Huawei MediaPad M5', 'Huawei MatePad Pro'
        ];
        
        
            $hinh_arr = [
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329328/realme-note-60-den-1-638618431980020061-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329008/redmi-14c-xanh-duong-1-638618466993077110-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/328449/oppo-a3x-do-1-638611485944050736-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/240259/iphone-14-tim-1-3-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/323563/samsung-galaxy-m35-5g-xanh-dam-1-1-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/245545/iphone-14-plus-xanh-1-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/281570/iphone-15-1-1-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/326016/vivo-y28-cam-1-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329959/vivo-v40-lite-bac-1-638631652324926803-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/303891/iphone-15-plus-1-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/303891/iphone-15-plus-blue-2-638629457633185799-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/322096/samsung-galaxy-a55-5g-xanh-1-1-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/303831/iphone-15-pro-black-1-750x500.jpg',
                'https://cdn.tgdd.vn/Products/Images/42/323002/realme-c65-1-2-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329940/xiaomi-14t-pro-blue-1-638660517348794541-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/328605/realme-c65s-xanh-1-638603520210646089-750x500.jpg',
                'https://cdnv2.tgdd.vn/mwg-static/tgdd/Products/Images/42/329938/xiaomi-14t-xam-1-638635700973443455-750x500.jpg'
            ];

        $loaiSP_arr = DB::table('loai')->pluck( 'ten_loai', 'id',); /*  id là key, ten_loai là value*/
            $ram_arr = ['4GB', '8GB', '12GB', '16GB'];
            $dia_arr = ['64GB', '128GB', '256GB', '512GB', '1TB'];
            $mau_arr = ['Đen', 'Xám', 'Trắng', 'Bạc', 'Đỏ'];
            $cannang_arr = ['0.12', '0.15', '0.18', '0.20', '0.22', '0.25', '0.27', '0.30'];
            $cpu_arr = ['Apple A17 Bionic', 'Apple A16 Bionic', 'Qualcomm Snapdragon 8 Gen 2', 'Qualcomm Snapdragon 8 Gen 1', 'MediaTek Dimensity 9200', 'MediaTek Dimensity 9000', 'Samsung Exynos 2200', 'Google Tensor G3'];
            $he_dieu_hanh_arr = ['iOS', 'Android'];
            $do_phan_giai_man_hinh_arr = ['HD (1280x720)', 'Full HD (1920x1080)', 'Quad HD (2560x1440)', '4K (3840x2160)', '5K (5120x2880)'];
            $tan_so_quet_arr = ['60Hz', '90Hz', '120Hz', '144Hz', '165Hz'];
            $camera_chinh_arr = ['12MP', '16MP', '48MP', '64MP', '108MP'];
            $camera_phu_arr = ['5MP', '8MP', '13MP', '16MP', '20MP'];
            $pin_arr = ['3000mAh', '4000mAh', '5000mAh', '6000mAh', '7000mAh'];
            $cong_ket_noi_arr = ['USB Type-C', 'Lightning', 'USB-A', 'Headphone Jack', 'HDMI', 'DisplayPort'];
            $ket_noi_mang_arr = ['2G', '3G', '4G', '5G', 'Wi-Fi 6', 'Wi-Fi 5', 'Bluetooth 5.0', 'NFC'];
        for ($i=1; $i<=200; $i++){
            $gia = mt_rand(5000000, 30000000);
            $gia_km = $gia - mt_rand(1000000, 5000000);
            $tinh_chat = 0 ;// 0 bình thường, 1 giá rẻ, 2 giảm sốc, 3 cao cấp
            if ($gia >= 28000000) $tinhchat = 3;  //cao cấp
            else if ($gia - $gia_km >= 3000000) $tinh_chat = 2; //giảm sốc
            else if ($gia<=6000000) $tinh_chat = 1;//giá rẻ
            else $tinhchat = 0; //bình thường
            $randtime = mt_rand(2022, 2024).'-'. mt_rand(1,12) .'-'. mt_rand(1,28) ." 23:59:59";
            $id_loai = mt_rand(1, count($loaiSP_arr)); ///  1- 12
            $ten_loai = $loaiSP_arr[$id_loai];
            if ($ten_loai === 'Apple') {
                $ten_sp = Arr::random($apple_arr);
            } elseif ($ten_loai === 'Samsung') {
                $ten_sp = Arr::random($samsung_arr);
            } elseif ($ten_loai === 'Xiaomi') {
                $ten_sp = Arr::random($xiaomi_arr);
            } elseif ($ten_loai === 'Oppo') {
                $ten_sp = Arr::random($oppo_arr);
            } elseif ($ten_loai === 'Vivo') {
                $ten_sp = Arr::random($vivo_arr);
            } elseif ($ten_loai === 'Huawei') {
                $ten_sp = Arr::random($huawei_arr);
            } else {
                $ten_sp = null; // Trường hợp không tìm thấy loại sản phẩm
            }
            $id = DB::table('san_pham')->insertGetId([
                'ten_sp' =>  $ten_sp, 
                'id_loai' => $id_loai,
                'hinh' => Arr::random($hinh_arr) ,
                'gia' => $gia, 
                'gia_km' => $gia_km, 
                'hot'=> (Arr::random([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]) %3==0)?1:0,
                'ngay' => $randtime ,
                'an_hien'=>(Arr::random([0,1,2,3,4,5,6,7,8,9,10]) %8==0)?0:1, 
                'luot_xem'=> mt_rand(0, 1000),
                'tinh_chat'=> $tinh_chat
            ]);
            $slug = Str::slug($ten_sp) . "-". $id;
            DB::table('san_pham')->where('id', $id)->update(['slug'=> $slug]);
            
            DB::table('thuoc_tinh')->insert([
                'id_sp' => $id ,
                'ram' => Arr::random($ram_arr),
                'cpu' => Arr::random($cpu_arr),
                'bo_nho' => Arr::random($dia_arr), // Dữ liệu cho bộ nhớ trong
                'mau_sac' => Arr::random($mau_arr),
                'can_nang' => Arr::random($cannang_arr),
                'he_dieu_hanh' => Arr::random($he_dieu_hanh_arr), // Hệ điều hành
                'do_phan_giai_man_hinh' => Arr::random($do_phan_giai_man_hinh_arr), // Độ phân giải màn hình
                'tan_so_quet' => Arr::random($tan_so_quet_arr), // Tần số quét
                'camera_chinh' => Arr::random($camera_chinh_arr), // Độ phân giải camera chính
                'camera_phu' => Arr::random($camera_phu_arr), // Độ phân giải camera phụ
                'pin' => Arr::random($pin_arr), // Dung lượng pin
                'cong_ket_noi' => Arr::random($cong_ket_noi_arr), // Cổng kết nối
                'ket_noi_mang' => Arr::random($ket_noi_mang_arr), // Kết nối mạng
            ]);
        }//for

    }//run
} //class
