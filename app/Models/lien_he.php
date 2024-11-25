<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lien_he extends Model
{
    use HasFactory;
    protected $table = 'lien_he'; 

    protected $fillable = ['ho_ten', 'email', 'dien_thoai', 'noi_dung', 'thoi_gian'];
}
