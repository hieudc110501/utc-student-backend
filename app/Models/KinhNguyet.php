<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinhNguyet extends Model
{
    protected $fillable = ['MaNguoiDung','TBNKN','NgayBatDau','SNCK','SNCT','CKDN','CKNN'];

    protected $primarkey =  'MaKinhNguyet';
    protected $table = 'KinhNguyet';
}
