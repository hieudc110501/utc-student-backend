<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class phanquyen extends Model
{
    use HasFactory;
    protected $fillable = ['maPhanQuyen', 'loaiQuyen'];

    protected $primaryKey =  'maPhanQuyen';
    protected $table = 'phanquyen';
}
