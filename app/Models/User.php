<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable  implements MustVerifyEmail  {
    use HasFactory, Notifiable;
    protected $fillable = [
        'name', 'email', 'password', 'dien_thoai', 'dia_chi', 'role','hinh','google_id','remember_token'
    ];
    protected $hidden = ['password','remember_token', ];
    protected function casts(): array{
        return ['email_verified_at' => 'datetime','password' => 'hashed',];
    }
    public function binh_luan(): HasMany {
        return $this->hasMany(binh_luan::class);
    }
}
