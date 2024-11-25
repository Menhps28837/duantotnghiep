<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yeu_cau_tra_hang extends Model
{
    use HasFactory;

    protected $table = 'yeu_cau_tra_hang';


    protected $fillable = ['id_dh', 'id_user', 'lydo'];

    public function order()
    {
        return $this->belongsTo(don_hang::class, 'id_dh');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
