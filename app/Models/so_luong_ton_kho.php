<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class so_luong_ton_kho extends Model
{
    use HasFactory;
    protected $table = 'so_luong_ton_kho';

    protected $fillable = ['id_sp', 'so_luong_con_lai', 'so_luong_canh_bao'];

    public function sanPham()
    {
        return $this->belongsTo(san_pham::class, 'id_sp');
    }
}
