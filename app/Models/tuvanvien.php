<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tuvanvien extends Model
{
    use HasFactory;
    protected $fillable = ['maTvv', 'tenTvv', 'linkZalo', 'soDienThoai', 'linkAnh'];
    protected $primaryKey =  'maTvv';
    protected $table = 'tuvanvien';
}
