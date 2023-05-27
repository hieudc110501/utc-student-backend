<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungThoiGian extends Model
{
    protected $fillable = ['MaNguoiDung','ThoiGian'];

    protected $primarkey =  'MaNhatKy';
    protected $table = 'NhatKy';
}
