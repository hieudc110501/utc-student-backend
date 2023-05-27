<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThaiKi extends Model
{
    protected $fillable = ['MaNguoiDung','NgayQuanHe','NgayTestThuThai','KetQuaVangDa'];

    protected $primarkey =  'MaThaiKi';
    protected $table = 'ThaiKi';
}
