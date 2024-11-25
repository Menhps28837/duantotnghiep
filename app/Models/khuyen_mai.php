<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khuyen_mai extends Model
{
    use HasFactory;
    protected $table = 'khuyen_mai'; 

    protected $fillable = ['id_sp', 'giam_gia', 'ngay_bat_dau', 'ngay_ket_thuc'];
}
