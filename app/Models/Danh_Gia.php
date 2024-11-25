<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danh_Gia extends Model
{
    protected $fillable = ['id_sp', 'id_user', 'rating', 'comment','id_dh'];
    protected $table = 'danhgia';

    public function product()
    {
        return $this->belongsTo(san_pham::class, 'id_sp');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function don_hang()
    {
        return $this->belongsTo(don_hang::class, 'id_dh');
    }
    // Mối quan hệ với bảng don_hang_chi_tiet
    public function don_hang_chi_tiet()
    {
        return $this->belongsTo(don_hang_chi_tiet::class, 'id_sp', 'id_sp'); // Liên kết với id_sp trong don_hang_chi_tiet
    }
}
