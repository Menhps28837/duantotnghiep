<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doanh_thu extends Model
{
    use HasFactory;
    protected $table = 'Doanh_thu';

    protected $fillable = ['id', 'id_dh', 'thang','nam','tong_doanh_thu','so_luong_don_hang'];
}
