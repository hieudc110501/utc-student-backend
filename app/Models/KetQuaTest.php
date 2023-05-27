<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetQuaTest extends Model
{
    protected $fillable = ['MaHopTest','LoaiQue','LanThu','ThoiGian','KetQua'];

    protected $primarkey =  'MaKetQuaTest';
    protected $table = 'KetQuaTest';
}
