<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class binh_luan extends Model {
    use HasFactory;

    protected $table = 'binh_luan';
    public $primaryKey = 'id';
    protected $fillable = ['id_sp', 'id_user', 'noi_dung', 'thoi_diem', 'an_hien', 'parent_id'];
    public $timestamps = true;
    protected $dates = ['thoi_diem'];

    // Quan hệ với sản phẩm
    public function san_pham(): BelongsTo {
        return $this->belongsTo(san_pham::class, 'id_sp');
    }

    // Quan hệ với người dùng
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Quan hệ bình luận con (nếu có)
    public function replies() {
        return $this->hasMany(binh_luan::class, 'parent_id');
    }

    // Quan hệ bình luận cha
    public function parent() {
        return $this->belongsTo(binh_luan::class, 'parent_id');
    }
}


