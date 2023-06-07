<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nguoidung extends Model
{
    use HasFactory;
    protected $fillable = ['maTaiKhoan', 'maTvv', 'tenNguoiDung', 'namSinh', 'chieuCao', 'canNang'];
    protected $primaryKey =  'maNguoiDung';
    protected $table = 'nguoidung';
}
