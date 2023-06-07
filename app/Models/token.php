<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class token extends Model
{
    use HasFactory;
    protected $fillable = ['tokenId', 'maNguoiDung', 'token', 'refreshToken', 'tokenExpired', 'refreshTokenExpired'];
    protected $primaryKey =  'tokenId';
    protected $table = 'token';
}
