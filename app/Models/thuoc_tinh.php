<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\san_pham;

class thuoc_tinh extends Model
{
    use HasFactory;
    protected $table = 'thuoc_tinh';
    public $primaryKey ='id';
    protected $fillable = ['id_sp','ram','cpu','dia_cung','mau_sac','can_nang', 'bao_hanh'];

    public function san_pham()
    {
        return $this->belongsTo(san_pham::class, 'id_sp', 'id'); // 'id_sp' là khóa ngoại trong bảng thuoc_tinh
    }
}

