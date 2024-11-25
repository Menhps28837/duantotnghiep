<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    use HasFactory;

    protected $table = 'tin_tuc';
    public $primaryKey = 'id';
    protected $dates = ['ngay_dang'];

    protected $fillable = ['tieu_de', 'noi_dung', 'anh', 'ngay_dang'];

}
