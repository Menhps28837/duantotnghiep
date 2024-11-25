<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class password_reset_tokens extends Model
{
    use HasFactory;
    public $primaryKey ='id';
    protected $fillable = [
        'email',
        'token'
    ];
    public function customer(){
        return $this->hasOne(User::class, 'email','email');
    }

    public function scopeCheckToken($q, $token){
        return $q->where('token',$token)->firstOrFail();
    }
}
