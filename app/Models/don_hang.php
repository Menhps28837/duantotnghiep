<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class don_hang extends Model
{
    use HasFactory;
    protected $table = 'don_hang';
    public $primaryKey ='id';

    protected $dates = ['thoi_diem'];

    protected $fillable = [
        'id_user',
        'id_ctdh',
        'ten_nguoi_nhan',
        'email',
        'dien_thoai',
        'dia_chi_giao',
        'tong_so_luong',
        'tong_tien',
        'thoi_diem_mua_hang',
        'trang_thai'
    ];
    public function don_hang_chi_tiets()
    {
        return $this->hasMany(don_hang_chi_tiet::class, 'id_dh');
    }
    public function yeu_cau_tra_hang()
    {
        return $this->hasOne(yeu_cau_tra_hang::class, 'id_dh');
    }
    public function reviews()
    {
        return $this->hasMany(Danh_Gia::class, 'id_dh'); // Một đơn hàng có nhiều đánh giá
    }
}
