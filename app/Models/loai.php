<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class loai extends Model {
    use HasFactory;
    protected $table = 'loai';
    public $primaryKey = 'id';
    protected $attributes = ['an_hien'=>0,'thu_tu'=>1];
    protected $dates = [];
    protected $fillable = ['ten_loai', 'thu_tu','an_hien','slug'];

}
