<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDungCauTraLoi extends Model
{
    protected $fillable = ['MaNguoiDungThoiGian', 'MaCauHoi','CauTraLoi'];

    protected $primarkey =  'MaNguoiDungCauTraiLoi';
    protected $table = 'NguoiDungCauTraiLoi';
}
