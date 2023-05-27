<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopTest extends Model
{
    protected $fillable = ['MaNguoiDung','SoLuong'];

    protected $primarkey =  'MaHopTest';
    protected $table = 'HopTest';
}
